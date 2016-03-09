<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/domain/actions/QuestionnaireRequest.php';

	class QuestionnaireController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnaireView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnaireView.php');

		}

		public function run(){
			/*
				The first parameter indicates the id of the questionnaire
				if it doesnt exist we redirect to the questionnairelist
			 */
			if( !isset( $this->params[1] ) ){
				$this->redirect("questionnaireslist");
			}

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
			 */
			if( isset($_POST["player-join"]) || isset($_POST["player-unjoin"]) || isset($_POST["player-cancel-request"]) ||
				isset($_POST["examiner-join"]) || isset($_POST["examiner-unjoin"]) || isset($_POST["examiner-cancel-request"]) ){
				$this->handleQuestionnaireRequest($this->params[1]);
			}

			/*
				Fetch the questionnaire
				Players can only see the public questionnaires
			 */
			$questionnaireMapper = new QuestionnaireMapper;
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

			/*
				The array items have the below properties
				"questionnaire"  			: the questionnaire object
				"participations" 			: The number of players
				"player-participation" 		: Boolean that shows whether the user participates as a player
				"examiner-participation"	: Boolean that shows whether the user participates as an examiner
				"active-player-request"		: Boolean that shows if the user has an active request to join the questionnaire as Player
				"active-examiner-request" 	: Boolean that shows if the user has an active request to join the questionnaire as Examiner
				"examiners-participating"   : All the examiners participating in this questionnaire, an array of Users objects.
				access them like this

				$questionnaires[ $key ]["questionnaire"];
			 */
			$this->setArg("questionnaire" , $questionnaireInfo);
		}


		public function handleQuestionnaireRequest($questionnaireId){
			
			$message = null;

			/*
				Validate message if exists
			 */
			if( isset($_POST["message"]) ){
				if(strlen($_POST["message"])<20 && strlen($_POST["message"])>255 ){
					$this->setArg("response-code" , 1); // Message validation error
					return;
				}
				$message = htmlspecialchars($_POST["message"] , ENT_QUOTES);
			}


			$requestMapper = new RequestMapper;
			$participationMapper = new ParticipationMapper;

			$questionnaireRequest = null;
			$participation = null;


			if( isset( $_POST["player-join"]) ){
				/*
					Player participation request
				 */
				if( $participationMapper->participates($_SESSION["USER_ID"] , $questionnaireId , 1 ) ){
					$this->setArg("response-code" , 3); // Player already participates
					return;
				}else if( $requestMapper->hasActivePlayerRequest($_SESSION["USER_ID"], $questionnaireId) ){
					$this->setArg("response-code" , 4); // Player has already an active request
					return;
				}

				$questionnaireRequest = new QuestionnaireRequest;
				$questionnaireRequest->setUserId($_SESSION["USER_ID"]);
				$questionnaireRequest->setRequestType(1); // Player Participation Request
				$questionnaireRequest->setRequestText($message);
				$questionnaireRequest->setQuestionnaireId($questionnaireId);

			}else if( isset($_POST["player-cancel-request"]) ){
				/*
					Delete active player participation request
				 */
				$questionnaireRequest = $requestMapper->getActivePlayerRequest($_SESSION["USER_ID"] , $questionnaireId);

				if( $questionnaireRequest === null){
					$this->setArg("response-code" , 5); // User has no active request to delete
					return;
				}

				$questionnaireRequest->setResponse(false);

			}else if( isset($_POST["player-unjoin"]) ){
				/*
					Remove Player Participation
				 */
				$participation = $participationMapper->findParticipation($_SESSION["USER_ID"] , $questionnaireId , 1 );

				if($participation === null){
					$this->setArg("response-code" , 6); // User didnt participate as player
					return;
				}

			}else if( isset($_POST["examiner-join"]) ){
				/*
					Examiner participation request
				 */
				if($_SESSION["USER_LEVEL"] <= 1){
					$this->setArg("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				if( $participationMapper->participates($_SESSION["USER_ID"] , $questionnaireId , 2 ) ){
					$this->setArg("response-code" , 8); // Examiner already participates
					return;
				}else if( $requestMapper->hasActiveExaminerRequest($_SESSION["USER_ID"], $questionnaireId) ){
					$this->setArg("response-code" , 9); // Examiner already has an active request
					return;
				}

				$questionnaireRequest = new QuestionnaireRequest;
				$questionnaireRequest->setUserId($_SESSION["USER_ID"]);
				$questionnaireRequest->setRequestType(2); // Player Participation Request
				$questionnaireRequest->setRequestText($message);
				$questionnaireRequest->setQuestionnaireId( $questionnaireId );

			}else if( isset($_POST["examiner-cancel-request"]) ){
				/*
					Delete active examiner participation request
				 */
				if($_SESSION["USER_LEVEL"] <= 1){
					$this->setArg("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				$questionnaireRequest = $requestMapper->getActiveExaminerRequest($_SESSION["USER_ID"] , $questionnaireId);

				if( $questionnaireRequest === null){
					$this->setArg("response-code" , 10); // User has no active examiner request to delete
					return;
				}

				$questionnaireRequest->setResponse(false);

			}else if( isset($_POST["examiner-unjoin"]) ){
				/*
					Remove Examiner Participation
				 */
				if($_SESSION["USER_LEVEL"] <= 1){
					$this->setArg("response-code" , 7); // Unauthorised action, user level is too low
					return;
				}

				$participation = $participationMapper->findParticipation($_SESSION["USER_ID"] , $questionnaireId , 2 );

				if($participation === null){
					$this->setArg("response-code" , 11); // User is not participating as examiner
					return;
				}

			}else{
				$this->setArg("response-code" , 2); // Invalid option
				return;
			}


			try{
				DatabaseConnection::getInstance()->startTransaction();

				if( $questionnaireRequest !== null ){

					$requestMapper->persist($questionnaireRequest);
				}else if( $participation !== null ){

					$participationMapper->delete($participation);
				}

				DatabaseConnection::getInstance()->commit();
				$this->setArg("response-code" , 0);

			}catch(DatabaseException $ex){
				DatabaseConnection::getInstance()->rollback();
				$this->setArg("response-code" , 12); // General database error
			}



		}

	}
