<?php
	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/user/User.php';
	include_once '../app/model/domain/user/Player.php';
	include_once '../app/model/domain/user/Examiner.php';
	include_once '../app/model/domain/user/Moderator.php';
	
	class UserMapper extends DataMapper{
		/*
			Prepared Statements
		 */
		private $insertStatement;
		private $deleteStatement;
		private $selectByIdStatement;
		private $updateStatement;

		public function findById($id){
			$statement = $this->getSelectByIdStatement();

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

			$statement = self::getUpdateStatement();

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


			$statement = self::getInsertStatement();

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
			$statement = $this->getDeleteStatement();

			$statement->setParameters("i" , $user->getId());

			$statement->executeUpdate();
		}

		public function getIdByEmail($email){
			$statement = DatabaseConnection::getInstance()->prepareStatement("select id from User where email=?");
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
			$statement = DatabaseConnection::getInstance()->prepareStatement("select email from User where email=?");
			$statement->setParameters("s" , $email);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}

		public function emailInUseNotByMe($email , $myId){
			$statement = DatabaseConnection::getInstance()->prepareStatement("select email from User where email=? and id<>?");
			$statement->setParameters("si" , $email , $myId);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}

		public function isBanned($userId){
			$query = "select banned from User where id=?";

			$statement = DatabaseConnection::getInstance()->prepareStatement($query);
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

			$preparedStatement = DatabaseConnection::getInstance()->prepareStatement($query);
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


		/*
			Get methods for the prepared statements.
			The PreparedStatents are created only when needed.
		 */
		private function getInsertStatement(){
			if( !isset($this->insertStatement) )
				$this->insertStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone,banned,deleted,verified) values (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			return $this->insertStatement;
		}

		private function getDeleteStatement(){
			if( !isset($this->deleteStatement) )
				$this->deleteStatement = DatabaseConnection::getInstance()->prepareStatement("delete from user where id=?");
			return $this->deleteStatement;
		}


		private function getSelectByIdStatement(){
			if( !isset($this->selectByIdStatement) )
				$this->selectByIdStatement = DatabaseConnection::getInstance()->prepareStatement("SELECT `id`, `email`, `access`, `name`, `surname`, `gender`, `country`, `city`, `address`, `phone`, `last_login` , `verified` , `banned` , `deleted` FROM `User` WHERE id=?");
			return $this->selectByIdStatement;
		}

		private function getUpdateStatement(){
			if( !isset($this->updateStatement)){
				$query = "UPDATE `User` SET `email`=?,`access`=?,`name`=?,`surname`=?,`gender`=?,`country`=?,`city`=?,`address`=?,`phone`=?, `password`=COALESCE(?,`password`) ,`banned`=? , `deleted`=? , `verified`=? WHERE `id`=?";

				$this->updateStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->updateStatement;
		}
	}