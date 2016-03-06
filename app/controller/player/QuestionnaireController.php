<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class QuestionnaireController extends Controller{
		
		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnaireView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnaireView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnaireView.php');
			
		}

		public function run(){
			if( !isset( $this->params[1] ) ){
				$this->redirect("questionnaireslist");
			}

			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaireInfo = null;

			if( $_SESSION["USER_LEVEL"] > 1)
				$questionnaireInfo = $questionnaireMapper->findWithInfoById( $this->params[1] , false );
			else
				$questionnaireInfo = $questionnaireMapper->findWithInfoById( $this->params[1] , true);

			if($questionnaireInfo === null)
				$this->redirect("questionnaireslist");

			$this->setArg("questionnaire" , $questionnaireInfo);
		}

	}