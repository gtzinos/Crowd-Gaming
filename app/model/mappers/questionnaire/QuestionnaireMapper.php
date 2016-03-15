<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Questionnaire.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class QuestionnaireMapper extends DataMapper{

		/*
			Return
		 */
		public function findWithInfo($sorting , $limit , $offset , $public){
			$query = "SELECT `Questionnaire`.`id`, `Questionnaire`.`coordinator_id`,`Questionnaire`.`description` , `Questionnaire`.`name` , `Questionnaire`.`public` , `Questionnaire`.`message_required` , `Questionnaire`.`creation_date` , count( `QuestionnaireParticipation`.`user_id`) as participations
FROM `Questionnaire`
LEFT JOIN `QuestionnaireParticipation` on `QuestionnaireParticipation`.`questionnaire_id`=`Questionnaire`.`id` ";

			if($public)
				$query .= "WHERE `Questionnaire`.`public`=1 ";

			$query .= "GROUP BY `Questionnaire`.`id` ";

			if( $sorting == "date" )
				$query .= "ORDER BY `Questionnaire`.`id` DESC LIMIT ?,?";
			else if( $sorting == "name")
				$query .= "ORDER BY `Questionnaire`.`name` LIMIT ?,?";
			else if( $sorting == "pop")
				$query .= "ORDER BY participations DESC LIMIT ?,?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $offset ,$limit );

			$resultSet = $statement->execute();

			$participationMapper = new ParticipationMapper;
			$requestMapper = new RequestMapper;

			// init the array that will be returned
			$questionnaires = array();

			while( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCoordinatorId( $resultSet->get("coordinator_id") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setMessageRequired( $resultSet->get("message_required") );
				$questionnaire->setCreationDate( $resultSet->get("creation_date") );

				$arrayItem["questionnaire"] = $questionnaire;
				$arrayItem["participations"] = $resultSet->get("participations");
				$arrayItem["player-participation"] = $participationMapper->participates($_SESSION["USER_ID"] , $questionnaire->getId() , 1);
				$arrayItem["examiner-participation"] = $participationMapper->participates($_SESSION["USER_ID"] , $questionnaire->getId() , 2);
				$arrayItem["active-player-request"] = $requestMapper->hasActivePlayerRequest($_SESSION["USER_ID"], $questionnaire->getId() );
				$arrayItem["active-examiner-request"] = $requestMapper->hasActiveExaminerRequest($_SESSION["USER_ID"], $questionnaire->getId() );
				$questionnaires[] = $arrayItem;
			}

			return $questionnaires;
		}

		/*
			Return
		 */
		public function findWithInfoById($questionnaireId , $public){
			$query = "SELECT `Questionnaire`.`id`, `Questionnaire`.`coordinator_id`,`Questionnaire`.`description` , `Questionnaire`.`name` , `Questionnaire`.`public` , `Questionnaire`.`message_required` , `Questionnaire`.`creation_date` , count( `QuestionnaireParticipation`.`user_id`) as participations
FROM `Questionnaire`
LEFT JOIN `QuestionnaireParticipation` on `QuestionnaireParticipation`.`questionnaire_id`=`Questionnaire`.`id` WHERE `Questionnaire`.`id`=? ";

			if($public)
				$query .= "AND `Questionnaire`.`public`=1 ";
			$query .= "GROUP BY `Questionnaire`.`id` ";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$resultSet = $statement->execute();

			$participationMapper = new ParticipationMapper;
			$requestMapper = new RequestMapper;
			$userMapper = new UserMapper;


			if( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCoordinatorId( $resultSet->get("coordinator_id") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setMessageRequired( $resultSet->get("message_required") );
				$questionnaire->setCreationDate( $resultSet->get("creation_date") );

				$questionnaireInfo["questionnaire"] = $questionnaire;
				$questionnaireInfo["participations"] = $resultSet->get("participations");
				$questionnaireInfo["player-participation"] = $participationMapper->participates($_SESSION["USER_ID"] , $questionnaire->getId() , 1);
				$questionnaireInfo["examiner-participation"] = $participationMapper->participates($_SESSION["USER_ID"] , $questionnaire->getId() , 2);
				$questionnaireInfo["active-player-request"] = $requestMapper->hasActivePlayerRequest($_SESSION["USER_ID"], $questionnaire->getId() );
				$questionnaireInfo["active-examiner-request"] = $requestMapper->hasActiveExaminerRequest($_SESSION["USER_ID"], $questionnaire->getId() );
				$questionnaireInfo["members-participating"] = $userMapper->findAllParticipants($questionnaire->getId());
				$questionnaireInfo["coordinator"] = $userMapper->findById( $questionnaire->getCoordinatorId() );

				return $questionnaireInfo;
			}

			return null;
		}

		public function isMessageRequired( $questionnaireId ){
			$query = "SELECT `message_required` FROM `Questionnaire` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$set = $statement->execute();

			if( $set->next() ){
				if( $set->get("message_required") == 1)
					return true;
			}
			return false;
		}

		public function getNumberOfPages( $public ){
			$query = "SELECT ceil(count(*)/10 ) as counter FROM `Questionnaire`";

			if( $public )
				$query .= " WHERE `public`=1";

			$statement = $this->getStatement($query);

			$res = $statement->execute();

			if( $res->next() ){
				return $res->get("counter");
			}
			return 0;
		}

		/*
			Returns a list of all questionnaires
		 */
		public function findAll(){

			$statement = $this->getStatement("SELECT `id ,`coordinator_id`, `name`, `description`, `public`, `message_required`, `creation_date` FROM `Questionnaire`");

			$resultSet = $statement->execute();

			$questionnaires = array();

			while( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCoordinatorId( $resultSet->get("coordinator_id") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setMessageRequired( $resultSet->get("message_required") );
				$questionnaire->setCreationDate( $resultSet->get("creation_date") );

				$questionnaires[] = $questionnaire;
			}

			return $questionnaires;
		}

		/*
			Returns a list of all public questionnaires
		 */
		public function findPublic(){

			$statement = $this->getStatement("SELECT `id`, `coordinator_id`, `name`, `description`, `public`, `message_required`, `creation_date` FROM `Questionnaire` WHERE `public`=1");

			$resultSet = $statement->execute();

			$questionnaires = array();

			while( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $resultSet->get("id") );
				$questionnaire->setCoordinatorId( $resultSet->get("coordinator_id") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setMessageRequired( $resultSet->get("message_required") );
				$questionnaire->setCreationDate( $resultSet->get("creation_date") );

				$questionnaires[] = $questionnaire;
			}

			return $questionnaires;
		}

		/*
			Returns a questionnaire
			false if the questionnaire does not exist
		 */
		public function findById($questionnaireId){
			$statement = $this->getStatement("SELECT `coordinator_id`, `name`, `description`,`public`, `message_required`, `creation_date` FROM `Questionnaire` WHERE id=?");
			$statement->setParameters('i' , $questionnaireId);

			$resultSet = $statement->execute();

			if( $resultSet->next() ){
				$questionnaire  = new Questionnaire();

				$questionnaire->setId( $questionnaireId );
				$questionnaire->setCoordinatorId( $resultSet->get("coordinator_id") );
				$questionnaire->setDescription( $resultSet->get("description") );
				$questionnaire->setName( $resultSet->get("name") );
				$questionnaire->setPublic( $resultSet->get("public") );
				$questionnaire->setMessageRequired( $resultSet->get("message_required") );
				$questionnaire->setCreationDate( $resultSet->get("creation_date") );

				return $questionnaire;
			}

			return null;
		}

		/*
			Deletes a questionnaire from the database
		 */
		public function delete($questionnaire){
			$statement = $this->getStatement("DELETE FROM `Questionnaire` WHERE `id`=?");

			$statement->setParameters('i' , $questionnaire->getId() );

			$statement->executeUpdate();
		}


		/*
			Saves the state of a questionnaire in the database
		 */
		public function persist($questionnaire){
			if( $questionnaire->getId() === null){
				$this->_create($questionnaire);
			}else{
				$this->_update($questionnaire);
			}
		}

		/*
			Inserts the questionnaire to the database
		 */
		private function _create($questionnaire){
			$statement = $this->getStatement("INSERT INTO `Questionnaire` (`coordinator_id`, `name`, `description`, `public`, `message_required` ,`creation_date`) VALUES (?,?,?,?,?,?,CURRENT_TIMESTAMP)");

			$statement->setParameters( 'isssii' ,
				$questionnaire->getCoordinatorId(),
				$questionnaire->getName(),
				$questionnaire->getDescription(),
				$questionnaire->getPublic(),
				$questionnaire->getMessageRequired() );

			$statement->executeUpdate();

		}

		/*
			Updates a questionnaire in the databae
		 */
		private function _update($questionnaire){
			$statement = $this->getStatement("UPDATE `Questionnaire` SET  `coordinator_id`=?,`name`=?,`description`=?,`public`=?,`message_required`=? WHERE `id`=?");

			$statement->setParameters( 'isssiii' ,
				$questionnaire->getCoordinatorId(),
				$questionnaire->getName(),
				$questionnaire->getDescription(),
				$questionnaire->getPublic(),
				$questionnaire->getMessageRequired(),
				$questionnaire->getId()
			 	);

			$statement->executeUpdate();
		}


	}
