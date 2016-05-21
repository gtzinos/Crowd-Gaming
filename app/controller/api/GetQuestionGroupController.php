<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class GetQuestionGroupController extends AuthenticatedController
	{
		
		public function init()
		{
		}

		public function run()
		{
			$userId = $this->authenticateToken();

			$groupId = null;
			$questionnaireId = $this->params[1];

			if( isset( $this->params[3]) )
			{
				$groupId = $this->params[3];
			}

			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$userAnswerMapper = new UserAnswerMapper;

			$response = array();

			if( !$participationMapper->participates($userId , $questionnaireId , 1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$response["code"] = "604";
				$response["message"] = "Forbidden, You dont have access to that questionnaire";

				http_response_code(403);

			}
			else if( $groupId === null )
			{
				/*
					Return all question group that belong to this questionnaire
				 */
				$questionGroups = $questionGroupMapper->findByQuestionnaire($questionnaireId);

				$response["code"] = "200";
				$response["message"] = "Success";

				$response["question-group"] = array();

				foreach ($questionGroups as $questionGroup) 
				{

					$arrayItem["name"] = $questionGroup->getName();
					$arrayItem["latitude"] = $questionGroup->getLatitude();
					$arrayItem["longitude"] = $questionGroup->getLongitude();
					$arrayItem["radius"] = $questionGroup->getRadius();
					$arrayItem["creation_date"] = $questionGroup->getCreationDate();
					$arrayItem["id"] = $questionGroup->getId();
					$arrayItem["total-questions"] = $questionGroupMapper->findQuestionCount($questionGroup->getId());
					$arrayItem["answered-questions"] = $userAnswerMapper->findAnswersCountByGroup($questionGroup->getId() , $userId);
					$arrayItem["allowed-repeats"] = $questionGroup->getAllowedRepeats();
					$arrayItem["current-repeats"] = $questionGroupMapper->findRepeatCount($groupId , $userId);
					$response["question-group"][] = $arrayItem;
				}


			}
			else
			{
				/*
					Return a specific question group
				 */
				$questionGroup = $questionGroupMapper->findByQuestionnaireAndId($groupId , $questionnaireId);

				if($questionGroup !== null)
				{

					$response["code"] = "200";
					$response["message"] = "Success";

					$response["question-group"]["name"] = $questionGroup->getName();
					$response["question-group"]["latitude"] = $questionGroup->getLatitude();
					$response["question-group"]["longitude"] = $questionGroup->getLongitude();
					$response["question-group"]["radius"] = $questionGroup->getRadius();
					$response["question-group"]["creation_date"] = $questionGroup->getCreationDate();
					$response["question-group"]["id"] = $questionGroup->getId();
					$response["question-group"]["total-questions"] = $questionGroupMapper->findQuestionCount($questionGroup->getId());
					$response["question-group"]["answered-questions"] = $userAnswerMapper->findAnswersCountByGroup($questionGroup->getId() , $userId);


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