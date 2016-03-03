<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Questionnaire.php';

	class QuestionnaireMapper extends DataMapper{

		private $selectByIdStatement;
		private $selectAllStatement;
		private $selectPublicStatement;

		private $insertStatement;
		private $updateStatement;
		private $deleteStatement;

		/*
			Returns a list of all questionnaires
		 */
		public function findAll(){

			$statement = $this->getSelectAllStatement();

			$resultSet = $statement->execute();

			$questionnaires = array();

			while( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCreatorId( $resultSet->get("creatorid") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setUpdated( $resultSet->get("updated") );

				$questionnaires[] = $questionnaire;
			}

			return $questionnaires;
		}

		/*
			Returns a list of all public questionnaires
		 */
		public function findPublic(){

			$statement = $this->getSelectPublicStatement();

			$resultSet = $statement->execute();

			$questionnaires = array();

			while( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCreatorId( $resultSet->get("creatorid") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setUpdated( $resultSet->get("updated") );

				$questionnaires[] = $questionnaire;
			}

			return $questionnaires;
		}

		/*
			Returns a questionnaire
			false if the questionnaire does not exist
		 */
		public function findById($questionnaireId){
			$statement = $this->getSelectByIdStatement();
			$statement->setParameters('i' , $questionnaireId);

			$resultSet = $statement->execute();

			if( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $questionnaireId );
				$questionnaire->setCreatorId( $resultSet->get("creatorid") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setUpdated( $resultSet->get("updated") );

				return $questionnaire;
			}

			return false;
		}

		/*
			Deletes a questionnaire from the database
		 */
		public function delete($questionnaire){
			$statement = $this->getDeleteStatement();

			$statement->setParameters('i' , $questionnaire->getId() );

			$statement->executeUpdate();
		}


		/*
			Saves the state of a questionnaire in the database
		 */
		public function persist($questionnaire){
			if( $questionnaire->getId() !== null){
				$this->_create($questionnaire);
			}else{
				$this->_update($questionnaire);
			}
		}

		/*
			Inserts the questionnaire to the database
		 */
		private function _create($questionnaire){
			$statement = $this->getInsertStatement();

			$statement->setParameters( 'isssi' ,
				$questionnaire->getCreatorId(),
				$questionnaire->getName(),
				$questionnaire->getDescription(),
				$questionnaire->getLanguage(),
				$questionnaire->getPublic() );

			$statement->executeUpdate();
		}

		/*
			Updates a questionnaire in the databae
		 */
		private function _update($questionnaire){
			$statement = $this->getUpdateStatement();

			$statement->setParameters( 'isssii' ,
				$questionnaire->getCreatorId(),
				$questionnaire->getName(),
				$questionnaire->getDescription(),
				$questionnaire->getLanguage(),
				$questionnaire->getPublic(),
				$questionnaire->getId() );

			$statement->executeUpdate();
		}

		/*
			Prepared Statement get Methods
		 */
		private function getSelectByIdStatement(){
			if( !isset( $this->selectByIdStatement ) ){
				$query = "SELECT `creatorid`, `name`, `description`, `language`, `public`, `updated` FROM `Questionnaire` WHERE id=?";
				$this->selectByIdStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->selectByIdStatement;
		}

		private function getSelectAllStatement(){
			if( !isset( $this->selectAllStatement ) ){
				$query = "SELECT `id ,`creatorid`, `name`, `description`, `language`, `public`, `updated` FROM `Questionnaire`";
				$this->selectAllStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->selectAllStatement;
		}

		private function getSelectPublicStatement(){
			if( !isset( $this->selectPublicStatement ) ){
				$query = "SELECT `id`, `creatorid`, `name`, `description`, `language`, `public`, `updated` FROM `Questionnaire` WHERE `public`=1";
				$this->selectPublicStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->selectPublicStatement;
		}

		private function getInsertStatement(){
			if( $this->insertStatement ){
				$query = "INSERT INTO `Questionnaire`(`creatorid`, `name`, `description`, `language`, `public`) VALUES (?,?,?,?,?)";
				$this->insertStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->insertStatement;
		}

		private function getUpdateStatement(){
			if( $this->updateStatement ){
				$query = "UPDATE `Questionnaire` SET  `creatorid`=?,`name`=?,`description`=?,`language`=?,`public`=? WHERE `id`=?";
				$this->updateStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->updateStatement;
		}

		private function getDeleteStatement(){
			if( $this->deleteStatement ){
				$query = "DELETE FROM `Questionnaire` WHERE `id`=?";
				$this->deleteStatement = DatabaseConnection::getInstance()->prepareStatement($query);
			}
			return $this->deleteStatement;
		}
	}