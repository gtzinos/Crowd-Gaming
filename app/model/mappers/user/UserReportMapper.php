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

		public function getReportByUser( $userId )
		{
			// Not implemented , I dont think this is needed.
		}

		public function getReportByQuestionnaire( $questionnaireId )
		{
			$query = "SELECT `Questionnaire`.`name` as qname , User.*, `UserReport`.* 
					  FROM `UserReport`
					  INNER JOIN `User` on `User`.`id`=`UserReport`.`user_id`
					  WHERE `UserReport`.`questionnaire_id=?";

			$statement = $this->getStatement($query);
			$statement->setParameters("i" , $questionnaireId);

			$set = $statement->execute();

			$output = array();

			while($set->next())
			{
				$item["questionnaire-name"] = $set->get("qname");
				$item["user-name"] = $set->get("name");
				$item["user-surname"] = $set->get("surname");
				$item["user-id"] = $set->get("user-id");
				$item["user-email"] = $set->get("email");
				$item["report-comment"] = $set->get("comment");
				$item["report-date"] = $set->get("report_date");
				
				$output[] = $item;
			}

			return $output;
		}

	}
