<?php
	include_once '../app/model/mappers/user/UserMapper.php';


	class ProfilePageController extends Controller{


		public function init(){

			if( isset($this->params[1]) && $this->params[1]=="ajax"){
				$this->setHeadless(true);
			}else{
				global $_CONFIG;

				$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

				$this->defSection('CSS','player/ProfilePageView.php');
				$this->defSection('JAVASCRIPT','player/ProfilePageView.php');
				$this->defSection('MAIN_CONTENT','player/ProfilePageView.php');
			}

		}

		public function run(){

			$mapper = new UserMapper();

			$user = $mapper->findById( $_SESSION["USER_ID"] );

			if( $user ){

				if( isset($this->params[1]) && $this->params[1]=="ajax"){
					if( isset($_POST["email"])       &&
						isset($_POST["currentpassword"]) && isset($_POST["name"])        && 
						isset($_POST["surname"])     &&	isset($_POST["gender"])      && 
						isset($_POST["city"])        && isset($_POST["country"]) ){

						$this->updateUser($user , $mapper);

					}else if( isset($_POST["currentpassword"]) ){

						$this->deleteUser($user , $mapper);
					}
				}

				$this->setArg("user" , $user);
			}else{
				// User with id SESSION["USER_ID"] does not exists
				// This error should never happen
				$this->setArg("error-code" , 1);
			}


		}

		private function deleteUser($user , $userMapper){

			$currentpassword = $_POST["currentpassword"];

			$result = $userMapper->authenticate($user->getEmail() , $_POST["currentpassword"]);

			if( !is_object($result) ){
				print '1'; // password is not correct
				die();
			}

			$user->setDeleted(true);

			try{
				DatabaseConnection::getInstance()->startTransaction();

				$userMapper->persist($user);

				DatabaseConnection::getInstance()->commit();

				$user->logout();
				/*
					This variables will be used by the DeleteAccountSuccessController.php
					to notify the user that the account was created but need to be
					verified.
				 */
				session_start();
				$_SESSION["SIGN_UP_CACHE_EMAIL"] = $user->getEmail();
				$_SESSION["SIGN_UP_CACHE_SURNAME"] = $user->getSurname();
				$_SESSION["SIGN_UP_CACHE_NAME"] = $user->getName();

				print  'TRUE'; // No Error , update Successful
			}catch(DatabaseException $ex){
				print '2'; // General Database Error
				DatabaseConnection::getInstance()->rollback();
			}
		}

		private function updateUser($user , $userMapper){
			/*
				Sanitizing
			 */
			$email = htmlspecialchars($_POST["email"] , ENT_QUOTES);
			$currentpassword = $_POST["currentpassword"];

			$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
			$surname = htmlspecialchars($_POST["surname"] , ENT_QUOTES);
			$gender = $_POST["gender"];
			$country = htmlspecialchars($_POST["country"] , ENT_QUOTES);
			$city = htmlspecialchars($_POST["city"] , ENT_QUOTES);

			if( isset($_POST["address"])){
				$address = htmlspecialchars($_POST["address"] , ENT_QUOTES);
			}

			if( isset($_POST["phone"]) ){
				$phone = htmlspecialchars($_POST["phone"] , ENT_QUOTES);
			}

			if( isset($_POST["newpassword"]) ){
				$newpassword = $_POST["newpassword"];
			}

			$result = $userMapper->authenticate($user->getEmail() , $_POST["currentpassword"]);

			if( !is_object($result) ){
				print '12'; // Old password is not correct
				die();
			}

			/*
				Validation
			 */
			if( strlen($email) < 3 || strlen($email) > 50 ){
				print '1'; // Email Validation Error
				die();
			}

			if( strlen($name) < 2 || strlen($name) > 40 ){
				print '2'; // Name Validation Error
				die();
			}

			if( strlen($surname) < 2 || strlen($surname) > 40 ){
				print '3'; // Surname Validation Error
				die();
			}

			if( $gender!= "1" && $gender!= "0"){
				print '4'; // Gender Validation Error
				die();
			}

			if( strlen($country) < 2 || strlen($country) > 40 ){
				print '5'; // Country Validation Error
				die();
			}

			if( strlen($city) < 2 || strlen($city) > 40 ){
				print '6'; // City Validation Error
				die();
			}

			if( isset($newpassword) && strlen($newpassword) < 8 ){
				print '7'; // Password Validation Error
				die();
			}else if( isset($newpassword) ){
				$newpassword = password_hash($newpassword , PASSWORD_DEFAULT);
			}

			if( isset($address) && ( strlen($address) < 2 || strlen($address) > 40 ) ){
				print '8'; // Address Validation Error
				die();
			}

			if( isset($phone) && ( strlen($phone) < 8 || strlen($phone) > 15 ) ){
				print '9'; // Phone Validation Error
				die();
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

			if( isset($newpassword) )
				$user->setPassword($newpassword);
			
			if( isset($address))
				$user->setAddress($address);

			if( isset($phone))
				$user->setPhone($phone);

			/*
				Update the user in the database
			 */
			try{
				DatabaseConnection::getInstance()->startTransaction();

				$userMapper->persist($user);

				DatabaseConnection::getInstance()->commit();
				print  'TRUE'; // No Error , update Successful
			}catch(EmailInUseException $e){
				print '10'; // Email in use
				DatabaseConnection::getInstance()->rollback();
			}catch(DatabaseException $ex){
				print '11'; // General Database Error
				DatabaseConnection::getInstance()->rollback();
			}
		}

	}
