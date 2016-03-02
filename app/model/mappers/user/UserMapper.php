<?php
	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/user/User.php';
	include_once '../app/model/domain/user/Player.php';
	include_once '../app/model/domain/user/Examiner.php';
	include_once '../app/model/domain/user/Moderator.php';
	
	class UserMapper extends DataMapper{

		public function findById($id){
			$statement = $this->getStatement("SELECT `id`, `email`, `access`, `name`, `surname`, `gender`, `country`, `city`, `address`, `phone`, `last_login` , `verified` , `banned` , `deleted` FROM `User` WHERE id=?");

			$statement->setParameters('i' ,$id);

			$resultSet = $statement->execute();

			if($resultSet->next()){

				$accessLevel = $resultSet->get("access");

				$user = 0;
				if( $accessLevel == 1 )
					$user = new Player();
				else if ( $accessLevel == 2)
					$user = new Examiner();
				else if ( $accessLevel == 3)
					$user = new Moderator();

				$user->setAccessLevel($accessLevel);
				$user->setId( $resultSet->get("id") );
				$user->setName( $resultSet->get("name") );
				$user->setSurname( $resultSet->get("surname") );
				$user->setEmail( $resultSet->get("email") );
				$user->setGender( $resultSet->get("gender") );
				$user->setCountry( $resultSet->get("country") );
				$user->setCity( $resultSet->get("city") );
				$user->setVerified( $resultSet->get("verified") );
				$user->setDeleted( $resultSet->get("banned") );
				$user->setBanned( $resultSet->get("banned") );

				if( $resultSet->get("address") !== null )
					$user->setAddress( $resultSet->get("address") );

				if( $resultSet->get("phone") !== null )
					$user->setPhone( $resultSet->get("phone") ); 

				return $user;
			}

			return false;
		}

		public function persist($user){
			$id =  $user->getId();
			if( isset( $id ) ){
				$this->_update($user);
			}else
				$this->_create($user);
		}


		private function _update($user){
			if( self::emailInUseNotByMe($user->getEmail() ,$user->getId() ) )
				throw new EmailInUseException("This email is in use by another user.");

			$statement = $this->getStatement("UPDATE `User` SET `email`=?,`access`=?,`name`=?,`surname`=?,`gender`=?,`country`=?,`city`=?,`address`=?,`phone`=?, `password`=COALESCE(?,`password`) ,`banned`=? , `deleted`=? , `verified`=? WHERE `id`=?");

			$statement->setParameters("sississsssiiii",	
				$user->getEmail(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone(),
				$user->getPassword(),
				$user->getBanned(),
				$user->getDeleted(),
				$user->getVerified(),
				$user->getId() );

			$statement->executeUpdate();
		}


		private function _create($user){
			if( self::emailInUse($user->getEmail()) )
				throw new EmailInUseException("This email is in use by another user.");


			$statement = $this->getStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone,banned,deleted,verified) values (?,?,?,?,?,?,?,?,?,?,?,?,?)");

			$statement->setParameters("ssississssiii",	
				$user->getEmail(),
				$user->getPassword(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone(),
				$user->getBanned(),
				$user->getDeleted(),
				$user->getVerified()  );

			$statement->executeUpdate();

		}



		/*
			Removes a user from the database
		 */
		public function delete($user){
			$statement = $this->getStatement("delete from user where id=?");

			$statement->setParameters("i" , $user->getId());

			$statement->executeUpdate();
		}

		public function getIdByEmail($email){
			$statement = $this->getStatement("select id from User where email=?");
			$statement->setParameters("s" ,$email);

			$resultSet = $statement->execute();

			if($resultSet->next()){
				return $resultSet->get("id");
			}
			return false;
		}

		/*
			Checks if an email already exists in the database
		 */
		public function emailInUse($email){
			$statement = $this->getStatement("select email from User where email=?");
			$statement->setParameters("s" , $email);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}


		public function emailInUseNotByMe($email , $myId){
			$statement = $this->getStatement("select email from User where email=? and id<>?");
			$statement->setParameters("si" , $email , $myId);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}

		public function isBanned($userId){
			$query = "select banned from User where id=?";

			$statement = $this->getStatement($query);

			$statement->setParameters("i" , $userId);

			$resultSet = $statement->execute();

			if($resultSet->next()){
				$banned = $resultSet->get("banned");

				if( $banned == "0" )
					return false;
				else
					return true;
			}else{
				/*
					Not really banned , if this code executes it means the user
					doesnt exists. We return true because its safer for the calling
					code to assume the user is banned than he is not.
				 */ 
				return true;
			}
		}


		/*
			Returns false if the authentication was failed.
			Returns the access level if the access level is below 0
			else it returns the user object meaning it was successful.
		 */
		public function authenticate($email , $password){
			$query =	"select User.password, AccessLevel.name, User.access, User.id , User.verified , User.deleted ,User.banned from User ".
						"inner join AccessLevel on AccessLevel.id = User.access ".
						"where User.email=?";

			$preparedStatement = $this->getStatement($query);
			$preparedStatement->setParameters('s' , $email);

			$set = $preparedStatement->execute();

			if($set->next()){
				$deleted = $set->get("deleted");
				$verified = $set->get("verified");
				$banned = $set->get("banned");

				if( !$verified)
					return "2";
				else if($deleted)
					return "3";
				else if($banned)
					return "4";

				$hashedPassword = $set->get("password");
				if(password_verify($password , $hashedPassword)){
					$user = 0;
					$userType = $set->get("name");
					if( $userType == "Player" )
						$user = new Player();
					else if( $userType == "Examiner")
						$user = new Examiner();
					else if( $userType == "Moderator");
						$user = new Moderator();
					$user->setDeleted($deleted);
					$user->setVerified($verified);
					$user->setBanned($banned);
					$user->setId( $set->get("id") );
					$user->setEmail( $email);
					$user->setAccessLevel( $set->get("access"));

					return $user;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

	}