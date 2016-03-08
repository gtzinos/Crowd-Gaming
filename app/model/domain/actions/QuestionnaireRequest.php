<?php

	class QuestionnaireRequest{

		private $id; // number
		private $userId; // number
		private $questionnaireId; // number
		private $requestType; // number
		private $requestText; // string
		private $requestDate; // string , timestamp in sql
		private $responseText; // string
		private $response; // boolean

		/*
			Getter and Setter bellow
		 */
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}

		public function getUserId(){
			return $this->userId;
		}
		
		public function setUserId($userId){
			$this->userId = $userId;
		}

		public function getQuestionnaireId(){
			return $this->questionnaireId;
		}
		
		public function setQuestionnaireId($questionnaireId){
			$this->questionnaireId = $questionnaireId;
		}
		
		public function getRequestType(){
			return $this->requestType;
		}
		
		public function setRequestType($requestType){
			$this->requestType = $requestType;
		}

		public function getRequestText(){
			return $this->requestText;
		}
		
		public function setRequestText($requestText){
			$this->requestText = $requestText;
		}

		public function getRequestDate(){
			return $this->requestDate;
		}
		
		public function setRequestDate($requestDate){
			$this->requestDate = $requestDate;
		}
		
		public function getResponse(){
			return $this->response;
		}
		
		public function setResponse($response){
			$this->response = $response;
		}

		public function getResponseText(){
			return $this->responseText;
		}
		
		public function setResponseText($responseText){
			$this->responseText = $responseText;
		}
	}