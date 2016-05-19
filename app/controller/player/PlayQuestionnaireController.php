<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class PlayQuestionnaireController extends Controller{

		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/PlayQuestionnaireView.php');
			$this->defSection('JAVASCRIPT','player/PlayQuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','player/PlayQuestionnaireView.php');
			$this->defSection('PLAY_GAME','player/PlayGameModal.php');
		}

		public function run(){
			/*
				The first parameter indicates the id of the questionnaire
				if it doesnt exist we redirect to the my-questionnaires page
			 */
			if( !isset( $this->params[1] ) )
			{
				$this->redirect("my-questionnaires");
			}

			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaire = $questionnaireMapper->findById($this->params[1]);

			if( $questionnaire === null )
			{
				$this->redirect("my-questionnaires");
			}

			$this->setArg("PAGE_TITLE",$questionnaire->getName());

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
				or time-left <> 0 or didnt participate as player
				Redirect the page to my-questionnaires
			 */
			if($questionnaireInfo === null || $questionnaireInfo["time-left"] != 0 || !$questionnaireInfo["player-participation"])
			//	$this->redirect("my-questionnaires");


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
			$this->setArg("questionnaire" , $questionnaireInfo);
		}

	}
