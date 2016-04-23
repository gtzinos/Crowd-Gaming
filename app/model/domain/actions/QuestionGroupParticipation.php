<?php

	class QuestionGroupParticipation
	
	{
		private $questionGroupId;
		private $userId; 

		public function getQuestionGroupId()
		{
			return $this->questionGroupId;
		}
		
		public function setQuestionGroupId($questionGroupId)
		{
			$this->questionGroupId = $questionGroupId;
		}

		public function getUserId()
		{
			return $this->userId;
		}
		
		public function setUserId($userId)
		{
			$this->userId = $userId;
		}
	}