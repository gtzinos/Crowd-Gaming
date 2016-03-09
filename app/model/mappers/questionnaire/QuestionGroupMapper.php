<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/QuestionGroup.php';

	class QuestionGroupMapper extends DataMapper{

		public function findAll(){
			$query = "SELECT * FROM `QuestionGroup`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("qid") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setAltitude( $set->get("altitude") );
				$questionGroup->setLongtitude( $set->get("longtitude") );
				$questionGroup->setAltitudeDeviation( $set->get("deviationA") );
				$questionGroup->setLongtitudeDeviation( $set->get("deviationL") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaire($questionnaireId){
			$query = "SELECT * FROM `QuestionGroup` WHERE `qid`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("qid") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setAltitude( $set->get("altitude") );
				$questionGroup->setLongtitude( $set->get("longtitude") );
				$questionGroup->setAltitudeDeviation( $set->get("deviationA") );
				$questionGroup->setLongtitudeDeviation( $set->get("deviationL") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findById($questionGroupId){
			$query = "SELECT * FROM `QuestionGroup` WHERE `id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			if($set->next()){
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("qid") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setDescription( $set->get("description") );
				$questionGroup->setAltitude( $set->get("altitude") );
				$questionGroup->setLongtitude( $set->get("longtitude") );
				$questionGroup->setAltitudeDeviation( $set->get("deviationA") );
				$questionGroup->setLongtitudeDeviation( $set->get("deviationL") );			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				return $questionGroup;
			}else
				return null;
		}

		public function delete($questionGroup){
			$query = "DELETE FROM `QuestionGroup` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroup->getId() );

			$statement->executeUpdate();
		}

		public function persist($questionGroup){
			if( $questionGroup->getId() === null ){
				$this->_create($questionGroup);
			}else{
				$this->_update($questionGroup);
			}
		}

		private function _create($questionGroup){
			$query = "INSERT INTO `QuestionGroup`(`qid`, `name`, `description`, `altitude`, `longitude`, `deviationA`, `deviationL`, `creation_date`) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);

			$statement->setParameters('issssss' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getDescription(),
				$questionGroup->getAltitude(),
				$questionGroup->getLongtitude(),
				$questionGroup->getAltitudeDeviation(),
				$questionGroup->getLongtitudeDeviation() );

			$statement->executeUpdate();
		}

		private function _update($questionGroup){
			$query = "UPDATE `QuestionGroup` SET `qid`=?,`name`=?,`description`=?,`altitude`=?,`longitude`=?,`deviationA`=?,`deviationL`=? WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('issssssi' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getDescription(),
				$questionGroup->getAltitude(),
				$questionGroup->getLongtitude(),
				$questionGroup->getAltitudeDeviation(),
				$questionGroup->getLongtitudeDeviation(),
				$questionGroup->getId() );

			$statement->executeUpdate();
		}

	}