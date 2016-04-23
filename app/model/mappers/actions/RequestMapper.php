<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Questionnaire.php';
	include_once '../app/model/domain/actions/QuestionnaireRequest.php';

	class RequestMapper extends DataMapper
	{

		public function findById($id)
		{
			//todo
		}

		public function getActivePlayerRequest($userId , $questionnaireId)
		{
			$query = "SELECT * FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=1 AND `accepted` IS NULL";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->next() )
			{
				
				$questionnaireRequest = new QuestionnaireRequest;
				$questionnaireRequest->setId( $res->get("id") );
				$questionnaireRequest->setUserId( $res->get("user_id") );
				$questionnaireRequest->setQuestionnaireId( $res->get("questionnaire_id") );
				$questionnaireRequest->setRequestType( $res->get("request_type") );
				$questionnaireRequest->setRequestText( $res->get("request_text") );
				$questionnaireRequest->setRequestDate( $res->get("request_date") );
				$questionnaireRequest->setResponseText( $res->get("response_text") );
				$questionnaireRequest->setResponse( $res->get("accepted") );

				return $questionnaireRequest;
			}
			return null;
		}

		public function getActiveExaminerRequest($userId , $questionnaireId)
		{
			$query = "SELECT * FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=2 AND `accepted` IS NULL";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->next() )
			{
				
				$questionnaireRequest = new QuestionnaireRequest;
				$questionnaireRequest->setId( $res->get("id") );
				$questionnaireRequest->setUserId( $res->get("user_id") );
				$questionnaireRequest->setQuestionnaireId( $res->get("questionnaire_id") );
				$questionnaireRequest->setRequestType( $res->get("request_type") );
				$questionnaireRequest->setRequestText( $res->get("request_text") );
				$questionnaireRequest->setRequestDate( $res->get("request_date") );
				$questionnaireRequest->setResponseText( $res->get("response_text") );
				$questionnaireRequest->setResponse( $res->get("accepted") );

				return $questionnaireRequest;
			}
			return null;
		}

		public function hasActivePlayerRequest( $userId, $questionnaireId )
		{
			$query = "SELECT `id` FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=1 AND `accepted` IS NULL";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->getRowCount() >0 )
				return true;
			return false;
		}

		public function hasActiveExaminerRequest( $userId, $questionnaireId )
		{
			$query = "SELECT `id` FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=2 AND `accepted` IS NULL";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->getRowCount() >0 )
				return true;
			return false;
		}

		public function hasActivePublishRequest( $questionnaireId )
		{
			$query = "SELECT `id` FROM `QuestionnaireRequest` WHERE `questionnaire_id`=? AND `request_type`=3 AND `accepted` IS NULL";

			$statement = $this->getStatement($query);
			$statement->setParameters('i', $questionnaireId);

			$res = $statement->execute();

			if( $res->getRowCount() >0 )
				return true;
			return false;
		}

		public function delete($request)
		{
			$query = "DELETE FROM `QuestionnaireRequest` WHERE `id`=?";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' , $request->getId());

			$statement->executeUpdate();
		}

		public function persist($request)
		{
			if( $request->getId() === null )
				$this->_create($request);
			else
				$this->_update($request);
		}

		private function _create($request)
		{
			$query = "INSERT INTO `QuestionnaireRequest`(`user_id`, `questionnaire_id`, `request_type`, `request_text`, `request_date`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";

			$statement = $this->getStatement($query);
			$statement->setParameters('iiis',
				$request->getUserId(),
				$request->getQuestionnaireId(),
				$request->getRequestType(),
				$request->getRequestText() );

			$statement->executeUpdate();
		}

		private function _update($request)
		{
			$query = "UPDATE `QuestionnaireRequest` SET `user_id`=?,`questionnaire_id`=?,`request_type`=?,`request_text`=?,`response_text`=?,`accepted`=? WHERE `id`=?";
			

			$statement = $this->getStatement($query);
			$statement->setParameters('iiissii',
				$request->getUserId(),
				$request->getQuestionnaireId(),
				$request->getRequestType(),
				$request->getRequestText(),
				$request->getResponseText(),
				$request->getResponse(),
				$request->getId() );

			$statement->executeUpdate();
		}		

	}