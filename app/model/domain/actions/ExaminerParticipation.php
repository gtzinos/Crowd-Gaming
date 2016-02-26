<?php
	include_once 'Participation.php';

	class ExaminerParticipation extends Participation{

		public function __construct(){
			$this->setParticipationType(2);
		}
		
	}