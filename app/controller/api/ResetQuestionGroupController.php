<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class ResetQuestionGroupController extends AuthenticatedController
	{
		
		public function init()
		{
		}

		public function run()
		{
			$userId = $this->authenticateToken();
			
			$questionnaireId = $this->params[1];
			$groupId = $this->params[3];
		
			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroupParticipationMapper = new QuestionGroupParticipationMapper;
			$userAnswerMapper = new UserAnswerMapper;
			$response = array();

		

			/*
				User participates to questionnaire
			 */
			if( !$participationMapper->participates($userId , $questionnaireId , 1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$response["code"] = "604";
				$response["message"] = "Forbidden, You dont have access to that questionnaire";

				http_response_code(403);
				print json_encode($response);
				return;
			}


			/*
				Question Group belongs to Questionnaire
			 */
			if( !$questionGroupMapper->groupBelongsTo($groupId , $questionnaireId) )
			{
				/*
					Question Group does not belong to questionnaire
				 */
				$response["code"] = "608";
				$response["message"] = "Not Found, Group doesnt not exist or doesnt belong to questionnaire";

				http_response_code(404);
				print json_encode($response);
				return;
			}

			$questionGroup = $questionGroupMapper->findById($groupId);

			$repeats = $questionGroupMapper->findRepeatCount($groupId,$userId);
			if( $repeats >= $questionGroup->getAllowedRepeats() )
			{
				$response["code"] = "611";
				$response["message"] = "Maximum times of question group replays reached.";

				http_response_code(403);
				print json_encode($response);
				return;
			}
			
			try
			{
				DatabaseConnection::getInstance()->startTransaction();
				
				$repeats++;
				$questionGroupMapper->persistRepeats($groupId , $userId , $repeats);
				$userAnswerMapper->deleteByGroupAndUser($groupId , $userId);


				DatabaseConnection::getInstance()->commit();
				$response["code"] = "200";
				$response["message"] = "Completed";
			}
			catch( DatabaseException $e)
			{
				DatabaseConnection::getInstance()->rollback();
				$response["code"] = "500";
				$response["message"] = "Internal server error.";
			}
			


			print json_encode($response);
		}

	}