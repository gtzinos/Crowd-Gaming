<?php

	include_once '../app/model/domain/user/Player.php';
	include_once '../app/model/mappers/user/UserMapper.php';
	require_once '../libs/PHPMailer-5.2.14/PHPMailerAutoload.php';

	class SignUpController extends Controller{


		public function init(){
			$this->setHeadless(true);
		}

		public function run(){
			
			if( isset($_SESSION["USER_ID"])  ||
				!(  isset($_POST["email"]) &&
					isset($_POST["name"]) &&
					isset($_POST["surname"]) &&
					isset($_POST["country"]) &&
					isset($_POST["city"]) &&
					isset($_POST["gender"]) &&
					isset($_POST["password"]) &&
					isset($_POST["licence"] )) )
			{
				$this->redirect("home");
			}

			if( $_POST["licence"] != 'accepted'){
				print 12; // licence not accepted
				die();
			}

			/*
				Sanitizing
			 */
			$email = htmlspecialchars($_POST["email"] , ENT_QUOTES);
			$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
			$surname = htmlspecialchars($_POST["surname"] , ENT_QUOTES);
			$gender = $_POST["gender"];
			$country = htmlspecialchars($_POST["country"] , ENT_QUOTES);
			$city = htmlspecialchars($_POST["city"] , ENT_QUOTES);
			$password = $_POST["password"];

			if( isset($_POST["address"])){
				$address = htmlspecialchars($_POST["address"] , ENT_QUOTES);
			}

			if( isset($_POST["phone"]) ){
				$phone = htmlspecialchars($_POST["phone"] , ENT_QUOTES);
			}

			/*
				Validation
			 */
			if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
				print '1';
				die();
			}

			if( strlen($name) < 2 || strlen($name) > 40 ){
				print '2';
				die();
			}

			if( strlen($surname) < 2 || strlen($surname) > 40 ){
				print '3';
				die();
			}

			if( $gender!= "1" && $gender!= "0"){
				print '4';
				die();
			}

			if( strlen($country) < 2 || strlen($country) > 40 ){
				print '5';
				die();
			}

			if( strlen($city) < 2 || strlen($city) > 40 ){
				print '6';
				die();
			}

			if( strlen($password) < 8 ){
				print '7';
				die();
			}else{
				$password = password_hash($password , PASSWORD_DEFAULT);
			}

			if( isset($address) && ( strlen($address) < 2 || strlen($address) > 40 ) ){
				print '8';
				die();
			}

			if( isset($phone) && ( strlen($phone) < 8 || strlen($phone) > 15 ) ){
				print '9';
				die();
			}


			/*
				Set data
			*/
			$player = new Player();

			$player->setEmail($email);
			$player->setName($name);
			$player->setSurname($surname);
			$player->setGender($gender);
			$player->setCountry($country);
			$player->setCity($city);
			$player->setAccessLevel(1); // Default account level is (1) Player.
			$player->setPassword($password);
			$player->setVerified(false);
			$player->setBanned(false);
			$player->setDeleted(false);

			if( isset($address))
				$player->setAddress($address);

			if( isset($phone))
				$player->setPhone($phone);


			// random string with 40 chars
			// 30 bytes are equal to 40 characters in base64, 6 bits = 1 char. (8*30) /6 = 40
			$activationToken = base64_encode(openssl_random_pseudo_bytes(30));

			// append the users email to the token, so it becomes unique
			$activationToken .= $player->getEmail();

			$activationToken = sha1($activationToken);

			$player->setEmailVerificationToken($activationToken);
			
			/*
				Insert the user in the database
			 */
			
			$userMapper = new UserMapper();


			try{
				DatabaseConnection::getInstance()->startTransaction();

				$userMapper->persist($player);
				
				$player->setId( $userMapper->getIdByEmail($player->getEmail() ) );

				$userMapper->updateEmailVerificationDate($player);

				global $_CONFIG;
				
				$mail = new PHPMailer;

				$mail->isSMTP();      
				$mail->Host = $_CONFIG["SMTP_HOST"];
				$mail->SMTPAuth = true; 
				$mail->Username = $_CONFIG["SMTP_USERNAME"];
				$mail->Password = $_CONFIG["SMTP_PASSWORD"];
				$mail->SMTPSecure = $_CONFIG["SMTP_SECURE"];
				$mail->Port = $_CONFIG["SMTP_PORT"];
				$mail->CharSet = 'UTF-8';

				$mail->setFrom($_CONFIG["SMTP_USERNAME"], 'Crowd Gaming Auto-Moderator');
				$mail->addAddress($player->getEmail(), $player->getName().' '.$player->getSurname());     // Add a recipient

				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Account Activation';
				$mail->Body    = "Thank you for creating an account. \n".
								 "Please go to this link to activate your account. \nhttp://".
								  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$player->getEmailVerificationToken();
				$mail->AltBody = "Thank you for creating an account. \n".
								 "Please go to this link to activate your account. \nhttp://".
								  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$player->getEmailVerificationToken();

				if(!$mail->send()) {
				    throw new Exception("Email failed to send. ". $mail->ErrorInfo);
				}

				DatabaseConnection::getInstance()->commit();

				/*
					This variables will be used by the SignUpSuccessController.php
					to notify the user that the account was created but need to be
					verified.
				 */
				$_SESSION["SIGN_UP_CACHE_EMAIL"] = $player->getEmail();
				$_SESSION["SIGN_UP_CACHE_SURNAME"] = $player->getSurname();
				$_SESSION["SIGN_UP_CACHE_NAME"] = $player->getName();


				print '0';
				
 			}catch(EmailInUseException $e){
				print '10';
				DatabaseConnection::getInstance()->rollback();
			}catch(DatabaseException $ex){
				print '11';
				DatabaseConnection::getInstance()->rollback();
			}catch(Exception $ex){
				print $ex->getMessage().'<br>';
				print '13'; // Email Error
				DatabaseConnection::getInstance()->rollback();
			}

		}


	}
