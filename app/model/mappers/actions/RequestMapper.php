<?php

	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/questionnaire/Questionnaire.php';

	class RequestMapper extends DataMapper{

		public function findById($id){
			//todo
		}

		public function hasActivePlayerRequest( $userId, $questionnaireId ){
			$query = "SELECT `id` FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=1";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->getRowCount() >0 )
				return true;
			return false;
		}

		public function hasActiveExaminerRequest( $userId, $questionnaireId ){
			$query = "SELECT `id` FROM `QuestionnaireRequest` WHERE `user_id`=? AND `questionnaire_id`=? AND `request_type`=2";

			$statement = $this->getStatement($query);
			$statement->setParameters('ii',$userId , $questionnaireId);

			$res = $statement->execute();

			if( $res->getRowCount() >0 )
				return true;
			return false;
		}

		public function delete($request){
			//todo
		}

		public function persist($request){
			if( $request->getId() === null )
				$this->_create($request);
			else
				$this->_update($request);
		}

		private function _create($request){
			//todo
		}

		private function _update($request){
			//todo
		}		

	}