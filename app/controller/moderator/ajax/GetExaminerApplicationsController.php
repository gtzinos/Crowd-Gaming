<?php

	include_once '../app/model/mappers/user/UserMapper.php';
	include_once '../app/model/mappers/actions/ExaminerApplicationMapper.php';

	class GetExaminerApplicationsController extends Controller
	{
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			$examinerApplicationMapper = new ExaminerApplicationMapper;

			$applications = $examinerApplicationMapper->findActiveApplications();

			$this->setOutput("applications" , $applications);

		}
	}