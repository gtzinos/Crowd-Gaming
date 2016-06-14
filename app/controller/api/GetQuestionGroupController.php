<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';

	class GetQuestionGroupController extends AuthenticatedController
	{
		
		public function init()
		{
			$this->setView( new JsonView );
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
			$playthroughMapper = new PlaythroughMapper;


			if( !$participationMapper->participates($userId , $questionnaireId , 1 , 1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$this->setOutput("code" , "604");
				$this->setOutput("message" , "Forbidden, You dont have access to that questionnaire");

				http_response_code(403);

			}
			else if( $groupId === null )
			{
				/*
					Return all question group that belong to this questionnaire
				 */
				$questionGroups = $questionGroupMapper->findByQuestionnaire($questionnaireId);

				$this->setOutput("code" ,"200");
				$this->setOutput("message","Success");


				$groupJsonArray = array();

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
					$arrayItem["current-repeats"] = $playthroughMapper->findRepeatCount($questionGroup->getId() , $userId);
					$arrayItem["time-left"] = $playthroughMapper->findTimeLeft($userId , $questionGroup->getId());
					$arrayItem["time-to-complete"] = $questionGroup->getTimeToComplete();
					$arrayItem["priority"] = $questionGroup->getPriority();
					$arrayItem["is-completed"] = $playthroughMapper->isCompleted($userId , $questionGroup->getId());

					$groupJsonArray[] = $arrayItem;
				}

				$this->setOutput("question-group",$groupJsonArray);

			}
			else
			{
				/*
					Return a specific question group
				 */
				$questionGroup = $questionGroupMapper->findByQuestionnaireAndId($groupId , $questionnaireId);

				if($questionGroup !== null)
				{

					$this->setOutput("code" , "200");
					$this->setOutput("message" ,"Success");

					$arrayItem["name"] = $questionGroup->getName();
					$arrayItem["latitude"] = $questionGroup->getLatitude();
					$arrayItem["longitude"] = $questionGroup->getLongitude();
					$arrayItem["radius"] = $questionGroup->getRadius();
					$arrayItem["creation_date"] = $questionGroup->getCreationDate();
					$arrayItem["id"] = $questionGroup->getId();
					$arrayItem["total-questions"] = $questionGroupMapper->findQuestionCount($questionGroup->getId());
					$arrayItem["answered-questions"] = $userAnswerMapper->findAnswersCountByGroup($questionGroup->getId() , $userId);
					$arrayItem["allowed-repeats"] = $questionGroup->getAllowedRepeats();
					$arrayItem["current-repeats"] = $playthroughMapper->findRepeatCount($questionGroup->getId() , $userId);
					$arrayItem["time-left"] = $playthroughMapper->findTimeLeft($userId , $questionGroup->getId());
					$arrayItem["time-to-complete"] = $questionGroup->getTimeToComplete();
					$arrayItem["priority"] = $questionGroup->getPriority();
					$arrayItem["is-completed"] = $playthroughMapper->isCompleted($userId , $questionGroup->getId());
					
					$this->setOutput("question-group",$arrayItem);
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