<?php

	include_once '../app/model/domain/user/Player.php';
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/user/ActivationMapper.php';
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
			if( strlen($email) < 3 || strlen($email) > 50 ){
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
			$player->setAccessLevel(1);
			$player->setPassword($password);
			$player->setVerified(false);
			$player->setBanned(false);
			$player->setDeleted(false);

			if( isset($address))
				$player->setAddress($address);

			if( isset($phone))
				$player->setPhone($phone);


			// random string with 100 chars
			// 75 bytes are equal to 100 characters in base64, 6 bits = 1 char. (8*75) /6 = 100
			$activationParameter = base64_encode(openssl_random_pseudo_bytes(75));
			// replace + and / with other characters, A Z were choosen for no important reason.
			// + / mess up he url. Only numbers and 
			$activationParameter = str_replace("+" , "A" , $activationParameter);
			$activationParameter = str_replace("/" , "Z" , $activationParameter); 
			
			/*
				Insert the user in the database
			 */
			
			$userMapper = new UserMapper();
			$activationMapper = new ActivationMapper();


			try{
				DatabaseConnection::getInstance()->startTransaction();

				$userMapper->persist($player);

				$id = $userMapper->getIdByEmail($player->getEmail());

				$activationMapper->insert($id , $activationParameter);

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
				$mail->addAddress($player->getEmail(), $player->getName().' '.$player->getSurname());     // Add a recipient

				$mail->isHTML(true);                                  // Set email format to HTML

				$mail->Subject = 'Account Activation';
				$mail->Body    = "Thank you for creating an account. \n".
								 "Please go to this link to activate your account. \nhttp://".
								  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$activationParameter;
				$mail->AltBody = "Thank you for creating an account. \n".
								 "Please go to this link to activate your account. \nhttp://".
								  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("activate").'/'.$activationParameter;

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


				print 'TRUE';
				
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
