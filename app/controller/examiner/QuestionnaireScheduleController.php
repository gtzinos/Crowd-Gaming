<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class QuestionnaireScheduleController extends Controller
	{
		
		public function init()
		{
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','examiner/QuestionnaireScheduleView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireScheduleView.php');
			$this->defSection('MAIN_CONTENT','examiner/QuestionnaireScheduleView.php');
			
		}

		public function run()
		{

			if( !isset($this->params[1] ) )
			{
				$this->redirect("questionnaireslist");
			}

			$questionnaireMapper = new QuestionnaireMapper;
			$scheduleMapper = new QuestionnaireScheduleMapper;

			$questionnaire = $questionnaireMapper->findById( $this->params[1] );

			if( $questionnaire === null || $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] )
			{
				$this->redirect("questionnaireslist");
			}


			$this->setArg("questionnaire" , $questionnaire );

			$schedule = $scheduleMapper->findByQuestionnaire( $questionnaire->getId() );

			$this->setArg("schedule" , $schedule);

		}

	}