<?php
	include_once '../app/model/orm/DataObject.php';
	include_once '../app/model/user/EmailInUseException.php';

	abstract class User extends DataObject{

		private $id;
		private $email;
		private $name;
		private $surname;
		private $gender;
		private $country;
		private $city;
		private $address;
		private $phone;
		private $lastLogin;
		private $createdDate;
		private $accessLevel;
		private $password;


		/**
		 *  Updates the data of this object in the database
		 *  
		 */
		public function update(){
			//TODO
		}

		/**
		 *  Inserts the data of this object in the database.
		 */
		public function insert(){
			
			if( self::emailInUse($this->email) )
				throw new EmailInUseException("This email is in use by another user.");

			if( isset($this->address) && isset($this->phone) ){

				$statement = self::getInsertFullStatement();

				$statement->setParameters("ssississss",	$this->email,$this->password,$this->accessLevel,$this->name,$this->surname,$this->gender,$this->country,$this->city,$this->address,$this->phone);
				$statement->executeUpdate();
			}else if( isset($this->address) ){

				$statement = self::getInsertWithAddressStatement();

				$statement->setParameters("ssississs",	$this->email,$this->password,$this->accessLevel,$this->name,$this->surname,$this->gender,$this->country,$this->city,$this->address);
				$statement->executeUpdate();
			}else if( isset($this->phone) ){
				
				$statement = self::getInsertWithPhoneStatement();

				$statement->setParameters("ssississs",	$this->email,$this->password,$this->accessLevel,$this->name,$this->surname,$this->gender,$this->country,$this->city,$this->phone);
				$statement->executeUpdate();
			}else{

				$statement = self::getInsertStatement();

				$statement->setParameters("ssississ",$this->email,$this->password,$this->accessLevel,$this->name,$this->surname,$this->gender,$this->country,$this->city);
				$statement->executeUpdate();
			}

		}

		public function remove(){
			$statement = self::getDeleteStatement();

			$statement->setParameters("i" , $this->id);

			$statement->executeUpdate();
		}


		public static function signin($email , $password){
			$query =	"select User.password, AccessLevel.name, User.access, User.id from User ".
						"inner join AccessLevel on AccessLevel.id = User.access ".
						"where User.email=?";

			$preparedStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			$preparedStatement->setParameters('s' , $email);

			$set = $preparedStatement->execute();

			if($set->next()){
				$hashedPassword = $set->get("password");

				if(password_verify($password , $hashedPassword)){
					$_SESSION["USER_LEVEL_STGRING"] = $set->get("name");
					$_SESSION["USER_LEVEL"] = $set->get("access");
					$_SESSION["USER_EMAIL"] = $email;
					$_SESSION["USER_ID"] = $set->get("id");
					return true;
				}else{
					return false;
				}

			}else{
				return false;
			}
		}


		public static function signout(){
			session_destroy();
		}


		public static function emailInUse($email){
			$statement = DatabaseConnection::getInstance()->prepareStatement("select email from User where email=?");
			$statement->setParameters("s" , $email);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}

		/*
			Prepared Statements
		 */
		private static $insertWithAddressStatement;
		private static $insertWithPhoneStatement;
		private static $insertFullStatement;
		private static $insertStatement;

		private static $deleteStatement;

		public static function getInsertWithAddressStatement(){
			if( !isset(self::$insertWithAddressStatement) )
				self::$insertWithAddressStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address) values (?,?,?,?,?,?,?,?,?)");
			return self::$insertWithAddressStatement;
		}

		public static function getInsertWithPhoneStatement(){
			if( !isset(self::$insertWithPhoneStatement) )
				self::$insertWithPhoneStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,phone) values (?,?,?,?,?,?,?,?,?)");
			return self::$insertWithPhoneStatement;
		}

		public static function getInsertFullStatement(){
			if( !isset(self::$insertFullStatement) )
				self::$insertFullStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone) values (?,?,?,?,?,?,?,?,?,?)");
			return self::$insertFullStatement;
		}

		public static function getInsertStatement(){
			if( !isset(self::$insertStatement) )
				self::$insertStatement = DatabaseConnection::getInstance()->prepareStatement("insert into User (email,password,access,name,surname,gender,country,city) values (?,?,?,?,?,?,?,?)");
			return self::$insertStatement;
		}

		public static function getDeleteStatement(){
			if( !isset(self::$deleteStatement) )
				self::$deleteStatement = DatabaseConnection::getInstance()->prepareStatement("delete from user where id=?");
			return self::$deleteStatement;
		}

		/*
			Get and Set methods bellow
		 */		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->setEdited(true);
			$this->id = $id;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->setEdited(true);
			$this->email = $email;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->setEdited(true);
			$this->name = $name;
		}

		public function getSurname(){
			return $this->surname;
		}

		public function setSurname($surname){
			$this->setEdited(true);
			$this->surname = $surname;
		}

		public function getGender(){
			return $this->gender;
		}

		public function setGender($gender){
			$this->setEdited(true);
			$this->gender = $gender;			
		}

		public function getCountry(){
			return $this->country;
		}

		public function setCountry($country){
			$this->setEdited(true);
			$this->country = $country;
		}

		public function getCity(){
			return $this->city;
		}

		public function setCity($city){
			$this->setEdited(true);
			$this->city = $city;
		}

		public function getAddress(){
			return $this->address;
		}

		public function setAddress($address){
			$this->setEdited(true);
			$this->address = $address;
		}

		public function getPhone(){
			return $this->phone;
		}

		public function setPhone($phone){
			$this->setEdited(true);
			$this->phone = $phone;
		}

		public function getLastLogin(){
			return $this->lastLogin;
		}

		public function setLastLogin($lastLogin){
			$this->setEdited(true);
			$this->lastLogin = $lastLogin;
		}

		public function getCreatedDate(){
			return $this->createdDate;
		}

		public function setCreatedDate($createdDate){
			$this->setEdited(true);
			$this->createdDate = $createdDate;
		}

		public function getAccessLevel(){
			return $this->accessLevel;
		}

		public function setAccessLevel($accessLevel){
			$this->accessLevel = $accessLevel;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setPassword($password){
			$this->password = $password;
		}
	}