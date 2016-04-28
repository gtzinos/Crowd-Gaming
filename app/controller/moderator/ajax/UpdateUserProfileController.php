<?php
	
	class UpdateUserProfileController extends Controller
	{
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus);
		}

		public function run()
		{

			if( isset( 	$_POST["user-id"], 
						$_POST["access"],
						$_POST["email"],
						$_POST["name"],
						$_POST["surname"],
						$_POST["gender"],
						$_POST["country"],
						$_POST["city"] ))
			{
				/*
					Sanitizing
				 */
				$email = htmlspecialchars($_POST["email"] , ENT_QUOTES);
				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);
				$surname = htmlspecialchars($_POST["surname"] , ENT_QUOTES);
				$gender = $_POST["gender"];
				$country = htmlspecialchars($_POST["country"] , ENT_QUOTES);
				$city = htmlspecialchars($_POST["city"] , ENT_QUOTES);
				$access = $_POST["access"];

				if( isset($_POST["address"]) )
				{
					$address = htmlspecialchars($_POST["address"] , ENT_QUOTES);
				}

				if( isset($_POST["phone"]) )
				{
					$phone = htmlspecialchars($_POST["phone"] , ENT_QUOTES);
				}

				if( isset($_POST["password"] ) )
				{
					$password = $_POST["password"];
				}

				$userMapper = new UserMapper;

				$user = $userMapper->findById($_POST["user-id"] );

				if( $user === null )
				{
					$this->setOutput('response-code' , 1);
					return;
				}

				/*
					Validation
				 */
				if( strlen($email) < 3 || strlen($email) > 50 )
				{
					$this->setOutput('response-code' ,2); // Email Validation Error
					return;
				}

				if( strlen($name) < 2 || strlen($name) > 40 )
				{
					$this->setOutput('response-code' ,3); // Name Validation Error
					return;
				}

				if( strlen($surname) < 2 || strlen($surname) > 40 )
				{
					$this->setOutput('response-code' ,4); // Surname Validation Error
					return;
				}

				if( $gender!= "1" && $gender!= "0")
				{
					$this->setOutput('response-code' ,5); // Gender Validation Error
					return;
				}

				if( strlen($country) < 2 || strlen($country) > 40 )
				{
					$this->setOutput('response-code' ,6); // Country Validation Error
					return;
				}

				if( strlen($city) < 2 || strlen($city) > 40 )
				{
					$this->setOutput('response-code' ,7); // City Validation Error
					return;
				}

				if( $access != 1 && $access != 2 && $access!=3)
				{
					$this->setOutput('response-code' , 8);
					return;
				}

				if( isset($address) && ( strlen($address) < 2 || strlen($address) > 40 ) )
				{
					$this->setOutput('response-code' , 9); // Address Validation Error
					return;
				}

				if( isset($phone) && ( strlen($phone) < 8 || strlen($phone) > 15 ) )
				{
					$this->setOutput('response-code' , 10); // Phone Validation Error
					return;
				}

				if( isset($password) && strlen($password) < 8)
				{
					$this->setOutput('response-code' , 11);
					return;
				}

				$user->setAccessLevel($access);
				$user->setEmail($email);
				$user->setName($name);
				$user->setSurname($surname);
				$user->setGender($gender);
				$user->setCountry($country);
				$user->setCity($city);

				if( isset($password) )
					$user->setPassword( password_hash( $password , PASSWORD_DEFAULT ) );
				
				if( isset($address))
					$user->setAddress($address);
				else
					$user->setAddress(null);

				if( isset($phone))
					$user->setPhone($phone);
				else
					$user->setPhone(null);

				/*
					Update the user in the database
				 */
				try
				{
					$userMapper->persist($user);

					$this->setOutput('response-code' , 0 ); // No Error , update Successful
				}
				catch(EmailInUseException $e)
				{
					$this->setOutput('response-code' , 12 ); // Email in use
				}
				catch(DatabaseException $ex)
				{
					$this->setOutput('response-code' , 13 ); // General Database Error
				}
				catch(Exception $exx)
				{
					$this->setOutput('response-code' , 14 ); // Could not Send email
				}
				
				return;
			}

			$this->setOutput('response-code' ,-1);
		}
	}