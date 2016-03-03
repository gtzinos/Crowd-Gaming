<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../libs/PHPMailer-5.2.14/PHPMailerAutoload.php';

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
				$this->setArg("response-code" , 1);
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

				print  '0'; // No Error , update Successful
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
			if($user->getEmail() != $email){
				$user->setNewEmail($email);

				// random string with 40 chars
				// 30 bytes are equal to 40 characters in base64, 6 bits = 1 char. (8*30) /6 = 40
				$activationToken = base64_encode(openssl_random_pseudo_bytes(30));

				// append the users email to the token, so it becomes unique
				$activationToken .= $user->getEmail();

				$activationToken = sha1($activationToken);

				$user->setEmailVerificationToken($activationToken);
			}

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

				if( $user->getEmail() != $email ){
					$userMapper->updateEmailVerificationDate($user);

					global $_CONFIG;
					$mail = new PHPMailer;

					$mail->isSMTP();      
					$mail->Host = $_CONFIG["SMTP_HOST"];
					$mail->SMTPAuth = true; 
					$mail->Username = $_CONFIG["SMTP_USERNAME"];
					$mail->Password = $_CONFIG["SMTP_PASSWORD"];;
					$mail->SMTPSecure = $_CONFIG["SMTP_SECURE"];;
					$mail->Port = $_CONFIG["SMTP_PORT"];;

					$mail->setFrom($_CONFIG["SMTP_USERNAME"], 'Crowd Gaming Auto-Moderator');
					$mail->addAddress($user->getNewEmail(), $user->getName().' '.$user->getSurname());     // Add a recipient

					$mail->isHTML(true);                                  // Set email format to HTML

					$mail->Subject = 'Email Verification';
					$mail->Body    = "You have requested to change your email address<br>".
									 "Please go to this link to verify that this email is indeed yours.<br>".
									 "After that you must use your new email address to login. Your old email will not be in use anymore<br>http://".
									  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$user->getEmailVerificationToken();

					$mail->AltBody = "You have requested to change your email address\n".
									 "Please go to this link to verify that this email is indeed yours.\n".
									 "After that you must use your new email address to login. Your old email will not be in use anymore\nhttp://".
									  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$user->getEmailVerificationToken();

					if(!$mail->send()) {
					    throw new Exception("Email failed to send. ". $mail->ErrorInfo);
					}
				}

				DatabaseConnection::getInstance()->commit();
				print  '0'; // No Error , update Successful
			}catch(EmailInUseException $e){
				print '10'; // Email in use
				DatabaseConnection::getInstance()->rollback();
			}catch(DatabaseException $ex){
				print '11'; // General Database Error
				DatabaseConnection::getInstance()->rollback();
			}catch(Exception $exx){
				print '13'; // Could not Send email
				DatabaseConnection::getInstance()->rollback();
			}
		}

	}
