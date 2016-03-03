<?php
	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/actions/ExaminerApplication.php';
	
	class ExaminerApplicationMapper extends DataMapper{

		public function persist($examinerApplication){
			if($examinerApplication->getId() === null ){
				$this->_create($examinerApplication);
			}else{
				$this->_update($examinerApplication);
			}
		}

		public function delete($examinerApplication){
			$statement = $this->getStatement("DELETE FROM `ExaminerApplication` WHERE `id`=?");

			$statement->setParameters('i' , $examinerApplication->getId());

			$statement->executeUpdate();
		}

		public function hasActiveApplication($userId){
			$statement = $this->getStatement("SELECT `id` FROM `ExaminerApplication` WHERE `uid`=? AND `accepted` IS NULL");

			$statement->setParameters('i' , $userId);

			$set = $statement->execute();

			if($set->getRowCount() > 0 ){
				return true;
			}else{
				return false;
			}
		}

		public function findById($applicationId){
			$statement = $this->getStatement("SELECT `uid`, `accepted`, `date`, `application_text` FROM `ExaminerApplication` WHERE `id`=?");

			$statement->setParameters('i' , $applicationId);

			$set = $statement->execute();

			if($set->next()){
				$examinerApplication = new ExaminerApplication;

				$examinerApplication->setId( $applicationId );
				$examinerApplication->setAccepted( $set->get("accepted") );
				$examinerApplication->setApplicationText( $set->get("application_text") );
				$examinerApplication->setApplicationDate( $set->get("date") );
				$examinerApplication->setUserId( $set->get("uid") );

				return $examinerApplication;
			}else{
				return false;
			}
		}

		private function _create($examinerApplication){
			$statement = $this->getStatement("INSERT INTO `ExaminerApplication` (`uid`,`date`, `application_text`) VALUES ( ? , CURRENT_TIMESTAMP,?)");
			
			$statement->setParameters("is", $examinerApplication->getUserId() , $examinerApplication->getApplicationText() );

			$statement->executeUpdate();
		}

		private function _update($examinerApplication){
			$statement = $this->getStatement("UPDATE `ExaminerApplication` SET `uid`=?,`accepted`=?,`application_text`=? WHERE `id`=?");

			$statement->setParameters("iisi",
				$examinerApplication->getUserId() ,
				$examinerApplication->isAccepted() ,
				$examinerApplication->getApplicationText() ,
				$examinerApplication->getId() );

			$statement->executeUpdate();
		}

	}