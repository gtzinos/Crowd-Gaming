<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/domain/actions/QuestionnaireRequest.php';
	include_once '../libs/PHPMailer-5.2.14/PHPMailerAutoload.php';

	class QuestionnaireController extends Controller
	{

		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','player/QuestionnaireView.php');
			$view->defSection('JAVASCRIPT','player/QuestionnaireView.php');
			$view->defSection('MAIN_CONTENT','player/QuestionnaireView.php');
			$view->defSection("QUESTIONNAIRE_OPTIONS" , "player/QuestionnaireOptionsModalView.php");
			$view->defSection("QUESTIONNAIRE_PLAYERS" , "player/QuestionnairePlayersModalView.php");
			$view->defSection("CONTACT_WITH_ONE_EMAIL" , "player/ContactModalView.php");
			$view->defSection("EDIT_QUESTIONNAIRE", "examiner/QuestionnaireEditModalView.php");
			$view->defSection("QUESTIONNAIRE_MEMBERS", "examiner/QuestionnaireMembersModalView.php");
			$view->defSection("QUESTIONNAIRE_SETTINGS", "examiner/QuestionnaireSettingsModalView.php");
			$view->defSection("REQUIRED_MESSAGE", "examiner/RequiredPasswordModalView.php");
			$view->defSection("QUESTIONNAIRE_RESULTS", "player/QuestionnaireScoresModalView.php");
			$this->setView( $view );
		}

		public function run()
		{
			/*
				The first parameter indicates the id of the questionnaire
				if it doesnt exist we redirect to the questionnairelist
			 */
			if( !isset( $this->params[1] ) )
			{
				$this->redirect("questionnaireslist");
			}
			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaire = $questionnaireMapper->findById($this->params[1]);

			if( $questionnaire === null )
			{
				$this->redirect("questionnaireslist");
			}

			$this->setOutput("PAGE_TITLE",$questionnaire->getName());
			/*
				User actions regarding the questionnaire
				eg , ParticipationRequest, remove Participation etc.

				after execution of handleQuestionnaireRequest()
				the argument "response-code" is set

				0  : All ok
				1  : Message validation error
				2  : Invalid Option
				3  : Player already participates
				4  : Player has already an active request
				5  : User has no active request to delete
				6  : User is not participating as player
				7  : Unauthorized action, user level is too low
				8  : Examiner already participates
				9  : Examiner already has an active request
				10 : User has no active examiner request to delete
				11 : User is not participating as examiner
				12 : General Database Error
				13 : Contact Message , Validation Error
				14 : Contact Message , Email Error
				15 : Message is Required
			 */
			if( $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] && (
				isset($_POST["player-join"]) ||
				isset($_POST["player-unjoin"]) ||
				isset($_POST["player-cancel-request"]) ||
				isset($_POST["examiner-join"]) ||
				isset($_POST["examiner-unjoin"]) ||
				isset($_POST["examiner-cancel-request"]) ) )
			{
				$questionnaire = $questionnaireMapper->findById($this->params[1]);
				$this->handleQuestionnaireRequest($this->params[1] , $questionnaireMapper->isMessageRequired($this->params[1]),$questionnaire->getMessage() );
			}

			/*
				Fetch the questionnaire
				Players can only see the public questionnaires
			 */
			$questionnaireInfo = null;
			if( $_SESSION["USER_LEVEL"] > 1)
				$questionnaireInfo = $questionnaireMapper->findWithInfoById( $this->params[1] , false );
			else
				$questionnaireInfo = $questionnaireMapper->findWithInfoById( $this->params[1] , true);

			/*
				Questionnaire does not exists
				Redirect the page to the list
			 */
			if($questionnaireInfo === null)
				$this->redirect("questionnaireslist");

			if( $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] && isset( $_POST["contact-message"]) )
			{
				$this->sendMailToCoordinator($_POST["contact-message"] , $questionnaireInfo);
			}

			/*
				The array items have the below properties
				"questionnaire"  			: the questionnaire object
				"participations" 			: The number of players
				"player-participation" 		: Boolean that shows whether the user participates as a player
				"examiner-participation"	: Boolean that shows whether the user participates as an examiner
				"active-player-request"		: Boolean that shows if the user has an active request to join the questionnaire as Player
				"active-examiner-request" 	: Boolean that shows if the user has an active request to join the questionnaire as Examiner
				"members-participating"     : All the members participating in this questionnaire, an array of Users objects.
				"coordinator"				: The coordinator user , User object.
				access them like this

				$questionnaires[ $key ]["questionnaire"];
			 */
			$this->setOutput("questionnaire" , $questionnaireInfo);
		}


		public function handleQuestionnaireRequest($questionnaireId , $messageRequired , $questionnaireMessage)
		{

			$message = null;

			/*
				Validate message if exists
			 */
			if( isset($_POST["message"]) )
			{
				if( $_POST["message"]!="" && ( strlen($_POST["message"])<3 || strlen($_POST["message"])>255) )
				{
					$this->setOutput("response-code" , 1); // Message validation error
					return;
				}
				else if( $_POST["message"] != "" )
				{
					$message = htmlspecialchars($_POST["message"] , ENT_QUOTES);
				}
			}


			$requestMapper = new RequestMapper;
			$participationMapper = new ParticipationMapper;
			$questionnaireMapper = new QuestionnaireMapper;
			$playthroughMapper = new PlaythroughMapper;

			$questionnaireRequest = null;
			$participation = null;
			$newParticipation = null;


			if( isset( $_POST["player-join"]) )
			{
				/*
					Player participation request
				 */
				if( $participationMapper->participates($_SESSION["USER_ID"] , $questionnaireId , 1 ) )
				{
					$this->setOutput("response-code" , 3); // Player already participates
					return;
				}
				else if( $requestMapper->hasActivePlayerRequest($_SESSION["USER_ID"], $questionnaireId) )
				{
					$this->setOutput("response-code" , 4); // Player has already an active request
					return;
				}
				else if( $messageRequired && $message===null)
				{
					$this->setOutput("response-code" , 15); // Message is required
					return;
				}
				else if( $messageRequired && $message==$questionnaireMessage)
				{
					$newParticipation = new Participation;
					$newParticipation->setUserId($_SESSION["USER_ID"]);
					$newParticipation->setQuestionnaireId($questionnaireId);
					$newParticipation->setParticipationType(1);
				}
				else
				{
					$questionnaireRequest = new QuestionnaireRequest;
					$questionnaireRequest->setUserId($_SESSION["USER_ID"]);
					$questionnaireRequest->setRequestType(1); // Player Participation Request
					$questionnaireRequest->setRequestText($message);
					$questionnaireRequest->setQuestionnaireId($questionnaireId);
				}
			}
			else if( isset($_POST["player-cancel-request"]) )
			{
				/*
					Delete active player participation request
				 */
				$questionnaireRequest = $requestMapper->getActivePlayerRequest($_SESSION["USER_ID"] , $questionnaireId);

				if( $questionnaireRequest === null)
				{
					$this->setOutput("response-code" , 5); // User has no active request to delete
					return;
				}

				$questionnaireRequest->setResponse(false);

			}
			else if( isset($_POST["player-unjoin"]) )
			{
				/*
					Remove Player Participation
				 */
				$participation = $participationMapper->findParticipation($_SESSION["USER_ID"] , $questionnaireId , 1 );

				if($participation === null)
				{
					$this->setOutput("response-code" , 6); // User didnt participate as player
					return;
				}

			}
			else if( isset($_POST["examiner-join"]) )
			{
				/*
					Examiner participation request
				 */
				if($_SESSION["USER_LEVEL"] <= 1)
				{
					$this->setOutput("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				if( $participationMapper->participates($_SESSION["USER_ID"] , $questionnaireId , 2 ) )
				{
					$this->setOutput("response-code" , 8); // Examiner already participates
					return;
				}else if( $requestMapper->hasActiveExaminerRequest($_SESSION["USER_ID"], $questionnaireId) )
				{
					$this->setOutput("response-code" , 9); // Examiner already has an active request
					return;
				}else if( $messageRequired && $message===null)
				{
					$this->setOutput("response-code" , 15); // Message is required
					return;
				}

				$questionnaireRequest = new QuestionnaireRequest;
				$questionnaireRequest->setUserId($_SESSION["USER_ID"]);
				$questionnaireRequest->setRequestType(2); // Player Participation Request
				$questionnaireRequest->setRequestText($message);
				$questionnaireRequest->setQuestionnaireId( $questionnaireId );

			}
			else if( isset($_POST["examiner-cancel-request"]) )
			{
				/*
					Delete active examiner participation request
				 */
				if($_SESSION["USER_LEVEL"] <= 1)
				{
					$this->setOutput("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				$questionnaireRequest = $requestMapper->getActiveExaminerRequest($_SESSION["USER_ID"] , $questionnaireId);

				if( $questionnaireRequest === null)
				{
					$this->setOutput("response-code" , 10); // User has no active examiner request to delete
					return;
				}

				$questionnaireRequest->setResponse(false);

			}
			else if( isset($_POST["examiner-unjoin"]) )
			{
				/*
					Remove Examiner Participation
				 */
				if($_SESSION["USER_LEVEL"] <= 1)
				{
					$this->setOutput("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				$participation = $participationMapper->findParticipation($_SESSION["USER_ID"] , $questionnaireId , 2 );

				if($participation === null)
				{
					$this->setOutput("response-code" , 11); // User is not participating as examiner
					return;
				}

			}
			else
			{
				$this->setOutput("response-code" , 2); // Invalid option
				return;
			}


			try
			{
				$this->setOutput("response-code" , 0);
				DatabaseConnection::getInstance()->startTransaction();

				if( $questionnaireRequest !== null )
				{

					$requestMapper->persist($questionnaireRequest);
				}
				else if( $participation !== null )
				{
					$playthroughMapper->deletePlaythrough( $participation->getUserId() , $participation->getQuestionnaireId() );
					$participationMapper->delete($participation);
				}
				else if( $newParticipation !== null)
				{
					$this->setOutput("response-code" , -1);
					$playthroughMapper->initPlaythrough($_SESSION["USER_ID"] , $questionnaireId );
					$participationMapper->persist($newParticipation);
				}

				DatabaseConnection::getInstance()->commit();
				

			}
			catch(DatabaseException $ex)
			{
				DatabaseConnection::getInstance()->rollback();
				$this->setOutput("response-code" , 12); // General database error
			}
	}

		public function sendMailToCoordinator($message , $questionnaireInfo)
		{

			$message = htmlspecialchars($message, ENT_QUOTES);

			if( strlen($message) < 19 || strlen($message) > 255 )
			{
				$this->setOutput("response-code" , 13); // Contact Message Validation Error
				return;
			}

			$userMapper = new userMapper;
			$user = $userMapper->findById($_SESSION["USER_ID"]);


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
			$mail->addAddress( $questionnaireInfo["coordinator"]->getEmail() , "Contact Support");     // Add a recipient

			$mail->isHTML(true);  // Set email format to HTML

			$mail->Subject = 'Questionnaire Contact, '.$questionnaireInfo["questionnaire"]->getName();

			$mail->Body    = "Questionnaire Contact <br>".
							 "About Questionnaire : ".$questionnaireInfo["questionnaire"]->getName(). ' id='.$questionnaireInfo["questionnaire"]->getId().'<br>'.
							 "<a href='http://".$_SERVER["HTTP_HOST"].LinkUtils::generatePageLink("user").'/'.
							$user->getId() . "' target='_blank'>View Profile</a>" .'<br>'.
							 "Name : ".$user->getName().' <br>'.
							 "Surname : ".$user->getSurname().' <br>'.
							 "Email : ".$user->getEmail().' <br>'.
							 "Message :  <br> <br>".$message;

			$mail->AltBody = "Questionnaire Contact \n".
							 "About Questionnaire : ".$questionnaireInfo["questionnaire"]->getName(). ' id='.$questionnaireInfo["questionnaire"]->getId().'\n'.
							 "Id : ".$user->getId().'\n'.
							 "Name : ".$user->getName().' \n'.
							 "Surname : ".$user->getSurname().' \n'.
							 "Email : ".$user->getEmail().' \n'.
							 "Message : \n \n".$message;

			if(!$mail->send())
			{
				$this->setOutput("response-code" , 14); // Email Error
			}else
			{
				// All went good
				$this->setOutput("response-code" , 0);
			}

		}

	}
