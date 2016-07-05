<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class GetQuestionnaireController extends AuthenticatedController
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			$userId = $this->authenticateToken();

			$questionnaireId = null;
			if( isset( $this->params[1] ) )
			{
				$questionnaireId = $this->params[1];
			}	

			$questionnaireMapper = new QuestionnaireMapper;
			$scheduleMapper = new QuestionnaireScheduleMapper;
			$userAnswerMapper = new UserAnswerMapper;
			$playthroughMapper = new PlaythroughMapper;

			if( $questionnaireId === null )
			{
				/*
					Get all the questionnaires that the user participates as player
				 */
				$questionnaires = $questionnaireMapper->findQuestionnairesByParticipation($userId,1);

				$this->setOutput("code" , "200");
				$this->setOutput("message" , "Completed");

				$questionnaireArray = array();
				foreach ($questionnaires as $questionnaire) 
				{
					
					if ( $questionnaire->getPublic() )
					{
						$questionnaireArrayItem["id"] = $questionnaire->getId();
						$questionnaireArrayItem["name"] = $questionnaire->getName();
						$questionnaireArrayItem["description"] = $questionnaire->getDescription();
						$questionnaireArrayItem["creation-date"] = $questionnaire->getCreationDate();
						$questionnaireArrayItem["time-left"] = $scheduleMapper->findMinutesToStart($questionnaire->getId());
						$questionnaireArrayItem["time-left-to-end"] = $scheduleMapper->findMinutesToEnd($questionnaire->getId());
						$questionnaireArrayItem["total-questions"] = $questionnaireMapper->findQuestionCountByUser($userId ,$questionnaire->getId());
						$questionnaireArrayItem["answered-questions"] = $userAnswerMapper->findAnswersCountByQuestionnaire($questionnaire->getId(), $userId);
						$questionnaireArrayItem["is-completed"] = $playthroughMapper->isQuestionnaireCompleted($userId , $questionnaire->getId() );
						$questionnaireArrayItem["allow-multiple-groups-playthrough"] = $questionnaire->getAllowMultipleGroups();
						$questionnaireArray[] = $questionnaireArrayItem;
					}	
				}

				$this->setOutput("questionnaire" , $questionnaireArray);

			}
			else
			{
				/*
					Get the questionnaire by id. The user must participate to this questionnaire
				 */
				$questionnaire = $questionnaireMapper->findQuestionnaireByParticipation($userId,$questionnaireId ,1);

				if($questionnaire !=null && $questionnaire->getPublic() )
				{
					$this->setOutput("code", "200");
					$this->setOutput("message", "Completed");

					$jsonObject["id"] = $questionnaire->getId();
					$jsonObject["name"] = $questionnaire->getName();
					$jsonObject["description"] = $questionnaire->getDescription();
					$jsonObject["creation-date"] = $questionnaire->getCreationDate();
					$jsonObject["time-left"] = $scheduleMapper->findMinutesToStart($questionnaire->getId());
					$jsonObject["time-left-to-end"] = $scheduleMapper->findMinutesToEnd($questionnaire->getId());
					$jsonObject["total-questions"] = $questionnaireMapper->findQuestionCountByUser($userId , $questionnaire->getId());
					$jsonObject["answered-questions"] = $userAnswerMapper->findAnswersCountByQuestionnaire($questionnaire->getId() , $userId);
					$jsonObject["allow-multiple-groups-playthrough"] = $questionnaire->getAllowMultipleGroups();
					$jsonObject["is-completed"] = $playthroughMapper->isQuestionnaireCompleted($userId, $questionnaire->getId());

					$this->setOutput("questionnaire" , $jsonObject);
				}
				else
				{
					http_response_code(404);
					$this->setOutput("code","404");
					$this->setOutput("message","Not Found");
				}
			}

		}

	}
