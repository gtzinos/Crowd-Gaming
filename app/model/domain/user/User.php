<?php
	include_once '../app/model/domain/user/EmailInUseException.php';

	class User {

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


		public function login(){
			$_SESSION["USER_LEVEL_STRING"] = get_class($this);
			$_SESSION["USER_LEVEL"] = $this->getAccessLevel();
			$_SESSION["USER_EMAIL"] = $this->getEmail();
			$_SESSION["USER_ID"] = $this->getId();
		}

		public function logout(){
			session_destroy();
		}

		/*
			Get and Set methods bellow
		 */		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getSurname(){
			return $this->surname;
		}

		public function setSurname($surname){
			$this->surname = $surname;
		}

		public function getGender(){
			return $this->gender;
		}

		public function getGenderString(){
			return $this->gender?"Female":"Male";
		}

		public function setGender($gender){
			$this->gender = $gender;			
		}

		public function getCountry(){
			return $this->country;
		}

		public function setCountry($country){
			$this->country = $country;
		}

		public function getCity(){
			return $this->city;
		}

		public function setCity($city){
			$this->city = $city;
		}

		public function getAddress(){
			return $this->address;
		}

		public function setAddress($address){
			$this->address = $address;
		}

		public function getPhone(){
			return $this->phone;
		}

		public function setPhone($phone){
			$this->phone = $phone;
		}

		public function getLastLogin(){
			return $this->lastLogin;
		}

		public function setLastLogin($lastLogin){
			$this->lastLogin = $lastLogin;
		}

		public function getCreatedDate(){
			return $this->createdDate;
		}

		public function setCreatedDate($createdDate){
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