<?php
	include_once '../app/model/orm/DataObject.php';


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
			//TODO
		}

		public static function signin($username , $password){
			//TODO
		}

		public static function signup(){
			//TODO
		}

		public static function signout(){
			//TODO
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
	}