<?php
	include_once 'QuestionnaireRequest.php';

	class ExaminerParticipationRequest extends QuestionnaireRequest{

		public function __construct(){
			$this->setRequestType(2);
		}
	}