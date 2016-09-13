<?php
	require_once '../libs/PHPMailer-5.2.14/PHPMailerAutoload.php';

	class ContactPageController extends Controller{

		public function init(){
			global $_CONFIG;

			$view = new HtmlView;


			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','public/ContactPageView.php');
			$view->defSection('JAVASCRIPT','public/ContactPageView.php');
			$view->defSection('MAIN_CONTENT','public/ContactPageView.php');

			$view->setArg("PAGE_TITLE","Contact with a Moderator");
			
			$this->setView($view);
		}

		public function run(){
			/*
				Output is "response-code" argument

				not set : User didnt send the form
				0		: Message was sent
				1		: Email validation error
				2		: Name validation error
				3		: Surname validation error
				4		: Messsage validation error
				5		: Phone validation error
				6		: Could not send email
				7		: Captcha Failed
			 */
			if( isset( $_POST["name"] , $_POST["surname"] , $_POST["email"] , $_POST["message"] , $_POST["phone"] , $_POST["g-recaptcha-response"])  ){
				$this->sendContactMail();
			}

		}

		public function sendContactMail(){

			$name = htmlspecialchars( $_POST["name"] , ENT_QUOTES);
			$surname = htmlspecialchars( $_POST["surname"] , ENT_QUOTES);
			$email = htmlspecialchars( $_POST["email"] , ENT_QUOTES);
			$message = htmlspecialchars($_POST["message"] , ENT_QUOTES);
			$phone = htmlspecialchars($_POST["phone"] , ENT_QUOTES);
			$captchaResponse = $_POST["g-recaptcha-response"];


			global $_CONFIG;
			/*
				Captcha Check
			 */
			$curl = curl_init();

			curl_setopt( $curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt( $curl, CURLOPT_POST ,1);
			curl_setopt( $curl, CURLOPT_POSTFIELDS , 'response='.$_POST['g-recaptcha-response'].'&secret='.$_CONFIG["SERVER_GOOGLE_RECAPTCHA_KEY"]);	
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0);
			
			$responseJson = curl_exec($curl);

			$response = json_decode($responseJson , true);

			if( $response["success"] != true )
			{
				$this->setArg("response-code" , 7);
				return;
			}

			/*
				Validation
			 */
			if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
				$this->setArg("response-code" , 1); // email validation error
				return;
			}

			if( strlen($name) < 2 || strlen($name) > 40 ){
				$this->setArg("response-code" , 2); // name validation error
				return;
			}

			if( strlen($surname) < 2 || strlen($surname) > 40 ){
				$this->setArg("response-code" , 3); // surname validation error
				return;
			}

			if( strlen($message) < 10 || strlen($message) > 255 ){
				$this->setArg("response-code" , 4); // message validation error
				return;
			}

			if( strlen($phone)!=0 && ( strlen($phone) < 8 || strlen($phone) > 15 ) ){
				$this->setArg("response-code" , 5); // phone validation error
				return;
			}

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
			
			$mail->setFrom($_CONFIG["SMTP_USERNAME"], 'Crowd Gaming Contact Support');
			$mail->addAddress($_CONFIG["CONTACT_EMAIL"], "Contact Support");     // Add a recipient

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Contact Support , Client: '.$name.' '.$surname;
			
			$mail->Body    = "Contact Mail <br>".
							 "Name : ".$name.' <br>'.
							 "Surname : ".$surname.' <br>'.
							 "Email : ".$email.' <br>'.
							 "Phone : ". ( strlen($phone)>0?$phone:"not given").' <br>'.
							 "Message  <br> <br>".$message;

			$mail->AltBody = "Contact Mail.\n".
							 "Name : ".$name.'\n'.
							 "Surname : ".$surname.'\n'.
							 "Email : ".$email.'\n'.
							 "Phone : ". ( strlen($phone)>0?$phone:"not given").'\n'.
							 "Message \n\n".$message;

			if(!$mail->send()) {
				// Email error
				$this->setArg("response-code" , 6);
			}else{
				// All went good
				$this->setArg("response-code" , 0);
			}
			

		}


	}
