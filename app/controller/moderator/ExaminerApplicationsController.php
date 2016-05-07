<?php

	class ExaminerApplicationsController extends Controller
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

				$this->defSection('CSS','moderator/ExaminerApplicationsView.php');
				$this->defSection('JAVASCRIPT','moderator/ExaminerApplicationsView.php');
				$this->defSection('MAIN_CONTENT','moderator/ExaminerApplicationsView.php');
			}

			$this->setArg("PAGE_TITLE","Examiner applications");
		}

		public function run()
		{


		}

	}
