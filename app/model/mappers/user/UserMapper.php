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
	
			$statement->setParameters("sississssi",	
				$user->getEmail(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone(),
				$user->getId() );

			$statement->executeUpdate();
		}


		private function _create($user){
			if( self::emailInUse($user->getEmail()) )
				throw new EmailInUseException("This email is in use by another user.");


			$statement = self::getInsertStatement();

			$statement->setParameters("ssississss",	
				$user->getEmail(),
				$user->getPassword(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone() );

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


		/*
			Returns false if the authentication was failed.
			Returns the access level if the access level is below 0
			else it returns the user object meaning it was successful.
		 */
		public function authenticate($email , $password){
			$query =	"select User.password, AccessLevel.name, User.access, User.id from User ".
						"inner join AccessLevel on AccessLevel.id = User.access ".
						"where User.email=?";

			$preparedStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			$preparedStatement->setParameters('s' , $email);

			$set = $preparedStatement->execute();

			if($set->next()){
				$accessLevel = $set->get("access");

				if($accessLevel<0)
					return $accessLevel;

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
				$this->insertStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone) values (?,?,?,?,?,?,?,?,?,?)");
			return $this->insertStatement;
		}

		private function getDeleteStatement(){
			if( !isset($this->deleteStatement) )
				$this->deleteStatement = DatabaseConnection::getInstance()->prepareStatement("delete from user where id=?");
			return $this->deleteStatement;
		}


		private function getSelectByIdStatement(){
			if( !isset($this->selectByIdStatement) )
				$this->selectByIdStatement = DatabaseConnection::getInstance()->prepareStatement("SELECT `id`, `email`, `access`, `name`, `surname`, `gender`, `country`, `city`, `address`, `phone`, `last_login` FROM `User` WHERE id=?");
			return $this->selectByIdStatement;
		}

		private function getUpdateStatement(){
			if( !isset($this->updateStatement)){
				$query = "UPDATE `User` SET `email`=?,`access`=?,`name`=?,`surname`=?,`gender`=?,`country`=?,`city`=?,`address`=?,`phone`=? WHERE `id`=?";

				$this->updateStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->updateStatement;
		}
	}