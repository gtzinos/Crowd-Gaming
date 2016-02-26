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
		private $insertWithAddressStatement;
		private $insertWithPhoneStatement;
		private $insertFullStatement;
		private $insertStatement;

		private $deleteStatement;

		public function findById($id){
			//todo
		}

		public function persist($user){
			$id =  $user->getId();
			if( isset( $id ) ){
				$this->_update($user);
			}else
				$this->_create($user);
		}


		private function _update($user){

		}


		private function _create($user){
			if( self::emailInUse($user->getEmail()) )
				throw new EmailInUseException("This email is in use by another user.");

			$address = $user->getAddress();
			$phone = $user->getPhone();

			if( isset($address) && isset($phone) ){

				$statement = self::getInsertFullStatement();

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

			}else if( isset($address) ){

				$statement = self::getInsertWithAddressStatement();

				$statement->setParameters("ssississs",	
					$user->getEmail(),
					$user->getPassword(),
					$user->getAccessLevel(),
					$user->getName(),
					$user->getSurname(),
					$user->getGender(),
					$user->getCountry(),
					$user->getCity(),
					$user->getAddress() );

				$statement->executeUpdate();

			}else if( isset($phone) ){
				
				$statement = self::getInsertWithPhoneStatement();

				$statement->setParameters("ssississs",	
					$user->getEmail(),
					$user->getPassword(),
					$user->getAccessLevel(),
					$user->getName(),
					$user->getSurname(),
					$user->getGender(),
					$user->getCountry(),
					$user->getCity(),
					$user->getPhone() );

				$statement->executeUpdate();

			}else{

				$statement = self::getInsertStatement();

				$statement->setParameters("ssississ",
					$user->getEmail(),
					$user->getPassword(),
					$user->getAccessLevel(),
					$user->getName(),
					$user->getSurname(),
					$user->getGender(),
					$user->getCountry(),
					$user->getCity() );

				$statement->executeUpdate();
			}
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


		public function authenticate($email , $password){
			$query =	"select User.password, AccessLevel.name, User.access, User.id from User ".
						"inner join AccessLevel on AccessLevel.id = User.access ".
						"where User.email=?";

			$preparedStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			$preparedStatement->setParameters('s' , $email);

			$set = $preparedStatement->execute();

			if($set->next()){
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
		private function getInsertWithAddressStatement(){
			if( !isset($this->insertWithAddressStatement) )
				$this->insertWithAddressStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address) values (?,?,?,?,?,?,?,?,?)");
			return $this->insertWithAddressStatement;
		}

		private function getInsertWithPhoneStatement(){
			if( !isset($this->insertWithPhoneStatement) )
				$this->insertWithPhoneStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,phone) values (?,?,?,?,?,?,?,?,?)");
			return $this->insertWithPhoneStatement;
		}

		private function getInsertFullStatement(){
			if( !isset($this->insertFullStatement) )
				$this->insertFullStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone) values (?,?,?,?,?,?,?,?,?,?)");
			return $this->insertFullStatement;
		}

		private function getInsertStatement(){
			if( !isset($this->insertStatement) )
				$this->insertStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city) values (?,?,?,?,?,?,?,?)");
			return $this->insertStatement;
		}

		private function getDeleteStatement(){
			if( !isset($this->deleteStatement) )
				$this->deleteStatement = DatabaseConnection::getInstance()->prepareStatement("delete from user where id=?");
			return $this->deleteStatement;
		}

	}