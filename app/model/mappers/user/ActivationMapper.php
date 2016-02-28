<?php

	include_once '../core/model/DataMapper.php';

	class ActivationMapper extends DataMapper{

		private $insertStatement;
		private $updateStatement;
		private $deleteStatement;
		private $selectStatement;
		private $selectByParameter;


		public function insert($userId , $activationParameter){

			$statement = $this->getInsertStatement();

			$statement->setParameters("is" , $userId , $activationParameter);

			$statement->executeUpdate();
		}

		public function update($userId , $activationParameter){
			$statement = $this->getUpdateStatement();

			$statement->setParameters("si" , $activationParameter , $userId);

			$statement->executeUpdate();
		}

		public function findById($userId){
			$statement = $this->getSelectStatement();

			$statement->setParameters("i" , $userId);

			$resultSet = $statement->execute();

			if($resultSet->next()){
				return $resultSet->get("activation_parameter");
			}else{
				return false;
			}
		}

		public function findByParameter($activationParameter){
			$statement = $this->getSelectByParameter();


			$statement->setParameters("s" , $activationParameter);

			$resultSet = $statement->execute();

			if($resultSet->next()){

				return $resultSet->get("user_id");
			}else{
				return false;
			}
		}

		public function delete($userId){
			$statement = $this->getDeleteStatement();

			$statement->setParameters("i" , $userId);

			$statement->executeUpdate();
		}


		/*
			Get methods for the statements
			The statements are created only when needed.
		 */
		private function getInsertStatement(){
			if( !isset($this->insertStatement) ){
				$query = "INSERT INTO `ActivationLink` (`user_id`, `activation_parameter`) VALUES (?, ?)";
				$this->insertStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->insertStatement;
		}

		private function getUpdateStatement(){
			if( !isset($this->updateStatement) ){
				$query = "UPDATE ActivationLink SET activation_parameter=? WHERE user_id=?";
				$this->updateStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->updateStatement;
		}

		private function getDeleteStatement(){
			if( !isset($this->deleteStatement) ){
				$query = "DELETE FROM ActivationLink WHERE user_id=?";
				$this->deleteStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->deleteStatement;
		}

		private function getSelectStatement(){
			if( !isset($this->selectStatement) ){
				$query = "SELECT activation_parameter FROM ActivationLink WHERE user_id=?";
				$this->selectStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->selectStatement;
		}

		private function getSelectByParameter(){
			if( !isset($this->selectByParameter) ){
				$query = "SELECT `user_id` FROM `ActivationLink` WHERE `activation_parameter`=?";
				$this->selectByParameter = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->selectByParameter;
		}
	}