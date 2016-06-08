<?php

	class ExaminerApplicationsController extends Controller
	{

		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;
			
			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$view->defSection('CSS','moderator/ExaminerApplicationsView.php');
			$view->defSection('JAVASCRIPT','moderator/ExaminerApplicationsView.php');
			$view->defSection('MAIN_CONTENT','moderator/ExaminerApplicationsView.php');
			$view->setArg("PAGE_TITLE","Examiner applications");

			$this->setView($view);
		}

		public function run()
		{


		}

	}
