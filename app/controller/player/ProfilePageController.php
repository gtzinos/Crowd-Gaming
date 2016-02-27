<?php
	include_once '../app/model/mappers/user/UserMapper.php';


	class ProfilePageController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/ProfilePageView.php');
			$this->defSection('JAVASCRIPT','player/ProfilePageView.php');
			$this->defSection('MAIN_CONTENT','player/ProfilePageView.php');

		}

		public function run(){

			$mapper = new UserMapper();

			$user = $mapper->findById( $_SESSION["USER_ID"] );

			if( $user ){
				// Use exists
				
				if( isset($_POST["email"])  && isset($_POST["name"]) && isset($_POST["surname"]) &&
					isset($_POST["gender"]) && isset($_POST["city"]) && isset($_POST["country"]) &&
					isset($_POST["address"]) && isset($_POST["phone"]) ){
					$this->updateUser($user , $mapper);
				}

				$this->setArg("user" , $user);
			}else{
				// User with id SESSION["USER_ID"] does not exists
				// This error should never happen
				$this->setArg("error-code" , 1);
			}


		}

		private function updateUser($user , $userMapper){
			/*
				Sanitizing
			 */
			$email = htmlspecialchars($_POST["email"] , ENT_QUOTES);
			$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
			$surname = htmlspecialchars($_POST["surname"] , ENT_QUOTES);
			$gender = $_POST["gender"];
			$country = htmlspecialchars($_POST["country"] , ENT_QUOTES);
			$city = htmlspecialchars($_POST["city"] , ENT_QUOTES);
			$address = htmlspecialchars($_POST["address"] , ENT_QUOTES);
			$phone = htmlspecialchars($_POST["phone"] , ENT_QUOTES);

			/*
				Validation
			 */
			if( strlen($email) < 3 || strlen($email) > 50 ){
				$this->setArg('error-code','2'); // Email Validation Error
				return;
			}

			if( strlen($name) < 2 || strlen($name) > 40 ){
				$this->setArg('error-code','3'); // Name Validation Error
				return;
			}

			if( strlen($surname) < 2 || strlen($surname) > 40 ){
				$this->setArg('error-code','4'); // Surname Validation Error
				return;
			}

			if( $gender!= "1" && $gender!= "0"){
				$this->setArg('error-code','5'); // Gender Validation Error
				return;
			}

			if( strlen($country) < 2 || strlen($country) > 40 ){
				$this->setArg('error-code','6'); // Country Validation Error
				return;
			}

			if( strlen($city) < 2 || strlen($city) > 40 ){
				$this->setArg('error-code','7'); // City Validation Error
				return;
			}

			if( $address !=='' && ( strlen($address) < 2 || strlen($address) > 40 ) ){
				$this->setArg('error-code','8'); // Address Validation Error
				return;
			}

			if( $phone !=='' && ( strlen($phone) < 8 || strlen($phone) > 15 ) ){
				$this->setArg('error-code','9'); // Phone Validation Error
				return;
			}

			/*
				Set the data
			 */
			$user->setEmail($email);
			$user->setName($name);
			$user->setSurname($surname);
			$user->setGender($gender);
			$user->setCountry($country);
			$user->setCity($city);

			if( $address !== '' )
				$user->setAddress($address);
			else if( $address ==='' && $user->getAddress() !==''){
				$user->setAddress(null);
			}

			if( $phone !== '' )
				$user->setPhone($phone);
			else if($phone ==='' && $user->getPhone() !==''){
				$user->setPhone(null);
			}

			try{
				DatabaseConnection::getInstance()->startTransaction();

				$userMapper->persist($user);

				DatabaseConnection::getInstance()->commit();
				$this->setArg('error-code', '0'); // No Error , update Successful
			}catch(EmailInUseException $e){
				$this->setArg('error-code','10'); // Email in user
				DatabaseConnection::getInstance()->rollback();
			}catch(DatabaseException $ex){
				$this->setArg('error-code','11'); // General Database Error
				DatabaseConnection::getInstance()->rollback();
			}
		}

	}
