<?php
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../libs/PHPMailer-5.2.14/PHPMailerAutoload.php';

	class PasswordRecoveryRequestController extends Controller{

		public function init(){
			$this->setHeadless(true);
		}

		public function run(){

			if( isset($_SESSION["USER_ID"]) )
				$this->redirect("");

			if( isset($_POST["email"]) ){

				$userMapper = new UserMapper;

				$user = $userMapper->findByEmail($_POST["email"]);

				if( is_object($user) ){
					// random string with 40 chars
					// 30 bytes are equal to 40 characters in base64, 6 bits = 1 char. (8*30) /6 = 40
					$token = base64_encode(openssl_random_pseudo_bytes(30));
					// append the users email to the token, so it becomes unique
					$token .= $user->getEmail();

					$token = sha1($token);
					$user->setPasswordRecoveryToken($token);

					try{
						DatabaseConnection::getInstance()->startTransaction();

						$userMapper->persist($user);
						$userMapper->updatePasswordRecoveryDate($user);

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
						$mail->addAddress($user->getEmail(), $user->getName().' '.$user->getSurname());     // Add a recipient

						$mail->isHTML(true);                                  // Set email format to HTML

						$mail->Subject = 'Password Recovery';
						$mail->Body    = "You have requested to reset your password.<br>".
										 "Please go to this link and set a new password.<br>".
										 "If you didnt request to change your password please ignore this message.<br>http://".
										  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("password-recovery").'/'.$user->getPasswordRecoveryToken();

						$mail->AltBody = "You have requested to reset your password. \n".
										 "Please go to this link and set a new password. \n".
										 "If you didnt request to change your password please ignore this message. \nhttp://".
										  $_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("password-recovery").'/'.$user->getPasswordRecoveryToken();

						if(!$mail->send()) {
						    throw new Exception("Email failed to send. ". $mail->ErrorInfo);
						}

						DatabaseConnection::getInstance()->commit();

		 			}catch(Exception $ex){
						DatabaseConnection::getInstance()->rollback();
					}

				}

				print '0';
			}


		}

	}
