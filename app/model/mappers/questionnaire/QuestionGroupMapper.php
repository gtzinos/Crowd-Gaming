<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/QuestionGroup.php';

	class QuestionGroupMapper extends DataMapper
	{

		public function findAll()
		{
			$query = "SELECT * FROM `QuestionGroup`";
			$statement = $this->getStatement($query);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next())
			{
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setRadius( $set->get("radius") );
				$questionGroup->setAllowedRepeats( $set->get("allowed_repeats"));	
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaire($questionnaireId)
		{
			$query = "SELECT * FROM `QuestionGroup` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next())
			{
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setRadius( $set->get("radius") );
				$questionGroup->setAllowedRepeats( $set->get("allowed_repeats"));
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaireLimited($questionnaireId , $offset , $count)
		{
			$query =   "SELECT * FROM `QuestionGroup` WHERE `questionnaire_id`=?
						ORDER BY id
						LIMIT ?,?";

			$statement = $this->getStatement($query);
			$statement->setParameters('iii' , $questionnaireId , $offset , $count);

			$set = $statement->execute();

			$questionGroups = array();

			while($set->next())
			{
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setRadius( $set->get("radius") );
				$questionGroup->setAllowedRepeats( $set->get("allowed_repeats"));
				$questionGroup->setCreationDate( $set->get("creation_date") );

				$questionGroups[] = $questionGroup;
			}

			return $questionGroups;
		}

		public function findByQuestionnaireAndId($questionGroupId , $questionnaireId)
		{
			$query = "SELECT * FROM `QuestionGroup` WHERE `id`=? AND `questionnaire_id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $questionGroupId , $questionnaireId);

			$set = $statement->execute();

			if($set->next())
			{
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setRadius( $set->get("radius") );
				$questionGroup->setAllowedRepeats( $set->get("allowed_repeats"));			
				$questionGroup->setCreationDate( $set->get("creation_date") );

				return $questionGroup;
			}else
				return null;
		}

		public function findById($questionGroupId)
		{
			$query = "SELECT * FROM `QuestionGroup` WHERE `id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId);

			$set = $statement->execute();

			if($set->next())
			{
				$questionGroup = new QuestionGroup;

				$questionGroup->setId( $set->get("id") );
				$questionGroup->setQuestionnaireId( $set->get("questionnaire_id") );
				$questionGroup->setName( $set->get("name") );
				$questionGroup->setLatitude( $set->get("latitude") );
				$questionGroup->setLongitude( $set->get("longitude") );
				$questionGroup->setRadius( $set->get("radius") );
				$questionGroup->setAllowedRepeats( $set->get("allowed_repeats"));		
				$questionGroup->setCreationDate( $set->get("creation_date") );

				return $questionGroup;
			}else
				return null;
		}


		public function requiresLocation( $groupId )
		{
			$query = "SELECT `id` FROM `QuestionGroup` WHERE `id`=? AND ( `latitude` is null OR `longitude` is null OR `radius` is null )";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $groupId);
			$set = $statement->execute();

			if( $set->getRowCount() > 0)
				return false;
			return true;
		} 

		public function nameExists($name)
		{
			$query  = "SELECT * FROM `QuestionGroup` WHERE `name`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters("s" , $name);

			$set = $statement->execute();

			if($set->getRowCount() > 0)
				return true;
			return false;
		}

		public function verifyLocation($groupId , $latitude , $longitude)
		{

			$query = "SELECT * FROM `QuestionGroup`
					  WHERE `id`=?
					  AND
						`radius` >= 6371000 * 2 * ATAN2( 
								
									SQRT(
										SIN( RADIANS( ? - `latitude` ) / 2  ) * SIN( RADIANS( ? - `latitude` ) / 2  ) +
										SIN( RADIANS( ? - `longitude` ) / 2  ) * SIN( RADIANS( ? - `longitude` ) / 2  ) *
										COS( RADIANS(`latitude`) ) * COS( RADIANS(?) )
										)
								,
									SQRT(
											1 - 
											(
												SIN( RADIANS( ? - `latitude` ) / 2  ) * SIN( RADIANS( ? - `latitude` ) / 2  ) +
												SIN( RADIANS( ? - `longitude` ) / 2  ) * SIN( RADIANS( ? - `longitude` ) / 2  ) *
												COS( RADIANS(`latitude`) ) * COS( RADIANS(?) )
											)
										)
								)"; 
			$statement = $this->getStatement($query);
			$statement->setParameters("issssssssss", 
				$groupId , 
				$latitude ,
				$latitude ,
				$longitude,
				$longitude,
				$latitude,	
				$latitude,
				$latitude,
				$longitude,
				$longitude,
				$latitude
			);

			$set = $statement->execute();

			if($set->getRowCount() >0)
				return true;
			return false;
		}

		public function findRepeatCount($groupId , $userId)
		{
			$query ="SELECT `repeat_count' FROM `QuestionGroupRepeats` 
					 WHERE `user_id`=? AND `question_group_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii', $userId , $groupId);

			$set = $statement->execute();

			if( $set->next() )
				return $set->get("repeat_count");
			return 0;
		}

		public function persistRepeats($groupId , $userId , $repeatCounter)
		{
			$query = "UPDATE `QuestionGroupRepeats` SET `repeat_count`=? WHERE `user_id`=? AND `question_group_id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('iii',$repeatCounter , $userId , $groupId);

			$set = $statement->executeUpdate();
		}

		public function deleteRepeats($groupId)
		{
			$query = "DELETE FROM `QuestionGroupRepeats` WHERE `question_group_id`=?";
			
			$statement = $this->getStatement($query);
			$statement->setParameters('i',$groupId);

			$set = $statement->executeUpdate();
		}

		public function groupBelongsTo($groupId , $questionnaireId)
		{
			$query  = "SELECT `Questionnaire`.`id` FROM `QuestionGroup` INNER JOIN `Questionnaire` ON `Questionnaire`.`id`=`QuestionGroup`.`questionnaire_id` WHERE `QuestionGroup`.`id`=? AND `QuestionGroup`.`questionnaire_id`=? ";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii' , $groupId , $questionnaireId);
			
			$set = $statement->execute();

			if($set->getRowCount() > 0)
				return true;
			return false;
		}

		public function delete($questionGroup)
		{
			$this->deleteById($questionGroup->getId());
		}

		public function deleteById($questionGroupId)
		{
			$query = "DELETE FROM `QuestionGroup` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionGroupId );

			$statement->executeUpdate();
		}

		public function deleteByQuestionnaire($questionnaireId)
		{
			$query = "DELETE FROM `QuestionGroup` WHERE `questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $questionnaireId );

			$statement->executeUpdate();
		}

		public function persist($questionGroup)
		{
			if( $questionGroup->getId() === null )
			{
				$this->_create($questionGroup);
			}
			else
			{
				$this->_update($questionGroup);
			}
		}

		private function _create($questionGroup)
		{
			$query = "INSERT INTO `QuestionGroup`(`questionnaire_id`, `name`,`latitude`, `longitude`, `radius`, `creation_date` ,`allowed_repeats`) VALUES (?,?,?,?,?,CURRENT_TIMESTAMP,?)";

			$statement = $this->getStatement($query);

			$statement->setParameters('isdddi' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getLatitude(),
				$questionGroup->getLongitude(),
				$questionGroup->getRadius() ,
				$questionGroup->getAllowedRepeats());

			$statement->executeUpdate();
		}

		private function _update($questionGroup)
		{
			$query = "UPDATE `QuestionGroup` SET `questionnaire_id`=?,`name`=?,`latitude`=?,`longitude`=?,`radius`=?,`allowed_repeats` WHERE `id`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('isdddii' , 
				$questionGroup->getQuestionnaireId(),
				$questionGroup->getName(),
				$questionGroup->getLatitude(),
				$questionGroup->getLongitude(),
				$questionGroup->getRadius(),
				$questionGroup->getAllowedRepeats(),
				$questionGroup->getId() );

			$statement->executeUpdate();
		}

	}