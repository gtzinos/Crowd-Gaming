<?php

	class QuestionnaireManagementController extends Controller
	{

		public function init()
		{
			if( isset($this->params[1]) && $this->params[1]=="ajax")
			{
				$this->setHeadless(true);
			}
			else
			{
				global $_CONFIG;

				$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

				$this->defSection('CSS','moderator/QuestionnaireManagementView.php');
				$this->defSection('JAVASCRIPT','moderator/QuestionnaireManagementView.php');
				$this->defSection('MAIN_CONTENT','moderator/QuestionnaireManagementView.php');

				$this->defSection('CONFIRM_QUESTIONNAIRE_DELETION','moderator/ConfirmQuestionnaireDeletetionModalView.php');
				$this->defSection('QUESTIONNAIRE_MANAGEMENT_SETTINGS','moderator/QuestionnaireManagementSettingsModalView.php');

			}

			$this->setArg("PAGE_TITLE","Questionnaire Management");
		}

		public function run()
		{


		}

	}
