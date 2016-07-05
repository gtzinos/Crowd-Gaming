<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
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
			$this->setView( new JsonView );
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
			$playthroughMapper = new PlaythroughMapper;


			/*
				User participates to questionnaire
			 */
			if( !$participationMapper->participates($userId , $questionnaireId , 1 ,1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$this->setOutput("code" ,  "604");
				$this->setOutput("message" ,  "Forbidden, You dont have access to that questionnaire");

				http_response_code(403);
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
				$this->setOutput("code" ,  "608");
				$this->setOutput("message" ,  "Not Found, Group doesnt not exist or doesnt belong to questionnaire");

				http_response_code(404);
				return;
			}

			$questionGroup = $questionGroupMapper->findById($groupId);


			if( $playthroughMapper->isCompleted($userId , $questionGroup->getId()) )
			{
				$this->setOutput("code", "607");
				$this->setOutput("message", "Forbidden , you cant reset this question group.");

				http_response_code(403);
				return;
			}


			$repeats = $playthroughMapper->findRepeatCount($userId,$groupId);
			if( $repeats >= $questionGroup->getAllowedRepeats() )
			{
				$this->setOutput("code" ,  "611");
				$this->setOutput("message" ,  "Maximum times of question group replays reached.");

				http_response_code(403);
				return;
			}


			
			try
			{
				DatabaseConnection::getInstance()->startTransaction();
				
				$repeats++;
				$playthroughMapper->persistRepeatCount($userId , $groupId , $repeats);
				$userAnswerMapper->deleteByGroupAndUser($groupId , $userId);
				$playthroughMapper->resetQuestionGroup($userId , $groupId );


				DatabaseConnection::getInstance()->commit();
				$this->setOutput("code" ,  "200");
				$this->setOutput("message" ,  "Completed");
			}
			catch( DatabaseException $e)
			{
				DatabaseConnection::getInstance()->rollback();
				$this->setOutput("code" ,  "500");
				$this->setOutput("message" ,  "Internal server error.");
			}
			
		}

	}