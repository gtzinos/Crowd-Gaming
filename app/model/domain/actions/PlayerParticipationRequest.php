<?php
	include_once 'QuestionnaireRequest.php';


	class PlayerParticipationRequest extends QuestionnaireRequest{
		public function __construct(){
			$this->setRequestType(1);
		}

	}