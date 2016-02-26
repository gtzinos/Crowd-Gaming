<?php
	include_once 'QuestionnaireRequest';

	class PublishingRequest extends QuestionnaireRequest{

		public function __construct(){
			$this->setRequestType(3);
		}

	}