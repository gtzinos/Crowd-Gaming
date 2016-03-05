<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class QuestionnairesListController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnairesListPageView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnairesListPageView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnairesListPageView.php');


		}

		public function run(){

			$questionnaireMapper = new QuestionnaireMapper;

			/*
				The array items have the below properties
				"questionnaire"  		: the questionnaire object
				"participations" 		: The number of players
				"user-participates" 	: Boolean that shows whether the user participates as a player
				access them like this

				$questionnaires[ $key ]["questionnaire"];
			 */
			$questionnaires = $questionnaireMapper->findPublicWithInfo(10 , 0);


			$this->setArg("questionnaires" , $questionnaires);

		}

	}
