<?php

	class QuestionnaireManagementController extends Controller
	{

		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','moderator/QuestionnaireManagementView.php');
			$view->defSection('JAVASCRIPT','moderator/QuestionnaireManagementView.php');
			$view->defSection('MAIN_CONTENT','moderator/QuestionnaireManagementView.php');

			$view->defSection('CONFIRM_QUESTIONNAIRE_DELETION','moderator/ConfirmQuestionnaireDeletetionModalView.php');
			$view->defSection('QUESTIONNAIRE_MANAGEMENT_SETTINGS','moderator/QuestionnaireManagementSettingsModalView.php');

			$view->setArg("PAGE_TITLE","Questionnaire Management");

			$this->setView($view);
		}

		public function run()
		{


		}

	}
