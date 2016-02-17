<?php
	include_once '../app/model/orm/DataObject.php';

	class Answer extends DataObject{
		private $id;
		private $correct;
		private $text;


		public function update(){

		}

		public function insert(){

		}


		/*
			Set and Get Methods bellow
		 */
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->setEdited(true);
			$this->id = $id;
		}

		public function isCorrect(){
			return $this->correct;
		}

		public function setCorrect($correct){
			$this->setEdited(true);
			$this->correct = $correct;
		}

		public function getText(){
			return $this->text;
		}

		public function setText($text){
			$this->setEdited(true);
			$this->text = $text;
		}
	}