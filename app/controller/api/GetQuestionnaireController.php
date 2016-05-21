<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class GetQuestionnaireController extends AuthenticatedController
	{
		
		public function init()
		{
		
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

			$response = array();

			if( $questionnaireId === null )
			{
				/*
					Get all the questionnaires that the user participates as player
				 */
				$questionnaires = $questionnaireMapper->findQuestionnairesByParticipation($userId,1);

				$response["code"] = "200";
				$response["message"] = "Completed";

				$questionnaireArray = array();
				foreach ($questionnaires as $questionnaire) 
				{

					$questionnaireArrayItem["id"] = $questionnaire->getId();
					$questionnaireArrayItem["name"] = $questionnaire->getName();
					$questionnaireArrayItem["description"] = $questionnaire->getDescription();
					$questionnaireArrayItem["creation-date"] = $questionnaire->getCreationDate();
					$questionnaireArrayItem["time-left"] = $scheduleMapper->findMinutesToStart($questionnaire->getId());
					$questionnaireArrayItem["time-left-to-end"] = $scheduleMapper->findMinutesToEnd($questionnaire->getId());
					$questionnaireArrayItem["total-questions"] = $questionnaireMapper->findQuestionCount($questionnaire->getId());
					$questionnaireArrayItem["answered-questions"] = $userAnswerMapper->findAnswersCountByQuestionnaire($questionnaire->getId(), $userId);
					$questionnaireArray[] = $questionnaireArrayItem;
				}

				$response["questionnaire"] = $questionnaireArray;

			}
			else
			{
				/*
					Get the questionnaire by id. The user must participate to this questionnaire
				 */
				$questionnaire = $questionnaireMapper->findQuestionnaireByParticipation($userId,$questionnaireId ,1);

				if($questionnaire !=null )
				{
					$response["code"] = "200";
					$response["message"] = "Completed";

					$response["questionnaire"]["id"] = $questionnaire->getId();
					$response["questionnaire"]["name"] = $questionnaire->getName();
					$response["questionnaire"]["description"] = $questionnaire->getDescription();
					$response["questionnaire"]["creation-date"] = $questionnaire->getCreationDate();
					$response["questionnaire"]["time-left"] = $scheduleMapper->findMinutesToStart($questionnaire->getId());
					$response["questionnaire"]["time-left-to-end"] = $scheduleMapper->findMinutesToEnd($questionnaire->getId());
					$response["questionnaire"]["total-questions"] = $questionnaireMapper->findQuestionCount($questionnaire->getId());
					$response["questionnaire"]["answered-questions"] = $userAnswerMapper->findAnswersCountByQuestionnaire($questionnaire->getId() , $userId);

				}
				else
				{
					http_response_code(404);
					$response["code"] = "404";
					$response["message"] = "Not Found";
				}
			}

			print json_encode($response);
		}

	}
