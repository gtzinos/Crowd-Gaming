<?php

	include_once '../core/model/DataMapper.php';

	class UserReportMapper extends DataMapper
	{

		public function insert( $userId, $questionnaireId , $comment)
		{

			$query = "INSERT INTO `UserReport` VALUES (?,?,? , CURRENT_TIMESTAMP )";

			$statement = $this->getStatement($query);
			$statement->setParameters("iis" , $userId , $questionnaireId , $comment);
			$statement->executeUpdate();
		}

		public function findReportByUser( $userId )
		{
			// Not implemented , I dont think this is needed.
		}

		public function findReportByQuestionnaire( $questionnaireId )
		{
			$query = "SELECT `Questionnaire`.`name` as qname , User.*, `UserReport`.* 
					  FROM `UserReport`
					  INNER JOIN `User` on `User`.`id`=`UserReport`.`user_id`
       				  INNER JOIN `Questionnaire` on `Questionnaire`.`id`=`UserReport`.`questionnaire_id`
					  WHERE `UserReport`.`questionnaire_id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters("i" , $questionnaireId);

			$set = $statement->execute();

			$output = array();

			while($set->next())
			{
				$item["questionnaire-id"] = $questionnaireId;
				$item["questionnaire-name"] = $set->get("qname");
				$item["user-name"] = $set->get("name");
				$item["user-surname"] = $set->get("surname");
				$item["user-id"] = $set->get("user_id");
				$item["user-email"] = $set->get("email");
				$item["report-comment"] = $set->get("comment");
				$item["report-date"] = $set->get("report_date");
				
				$output[] = $item;
			}

			return $output;
		}

		public function deleteByQuestionnaire($questionnaireId)
		{
			$query = "DELETE FROM `UserReport` WHERE `questionnaire_id`=?";
			$statement = $this->getStatement($query);
			$statement->setParameters("i" , $questionnaireId);

			$statement->executeUpdate();
		}

	}
