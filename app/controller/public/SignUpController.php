<?php

	include_once '../app/model/user/Player.php';
	include_once '../app/model/orm/ObjectManager.php';

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
					isset($_POST["password"]) ) )
			{
				$this->redirect("home");
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

			if( isset($address))
				$player->setAddress($address);

			if( isset($phone))
				$player->setPhone($phone);


			/*
				Map the object to the database
			 */
			
			$objectManager = new ObjectManager();

			$objectManager->persist($player);

			try{
				if( $objectManager->flush() ){
					print '11';
				}else{
					print 'TRUE';
				}
			}catch(EmailInUseException $e){
				print '10';
			}

		}

	}