<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';

	class GetQuestionController extends AuthenticatedController
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			// get ids
			$userId = $this->authenticateToken();
			$questionnaireId = $this->params[1];
			$groupId = $this->params[3];
			$questionId = null;


			// init mappers
			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroupParticipationMapper = new QuestionGroupParticipationMapper;
			$questionMapper = new QuestionMapper;
			$scheduleMapper = new QuestionnaireScheduleMapper;
			$playthroughMapper = new PlaythroughMapper;
			$questionnaireMapper = new QuestionnaireMapper;
			$userAnswerMapper = new UserAnswerMapper;


			// Variables
			$groupHasStarted = $playthroughMapper->hasStarted($userId ,$groupId);
			$timeLeftToStart = $scheduleMapper->findMinutesToStart($questionnaireId);
			$participates = $participationMapper->participates($userId , $questionnaireId , 1 ,1);
			$groupBelongsToQuestionnaire = $questionGroupMapper->groupBelongsTo($groupId , $questionnaireId);
			$currentRepeats = $playthroughMapper->findRepeatCount($userId , $groupId);
			$groupCompleted = $playthroughMapper->isCompleted($userId ,$groupId);
			$activeGroups = $playthroughMapper->findActiveGroupCount($userId, $questionnaireId);

			if( $timeLeftToStart != 0)
			{
				/*
					Questionnaire Offline
				 */
				$this->setOutput("code", "603");
				$this->setOutput("message", "Forbidden, Questionnaire offline");

				http_response_code(403);

				return;
			}
		

			/*
				User participates to questionnaire
			 */
			if( !$participates )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$this->setOutput("code", "604");
				$this->setOutput("message", "Forbidden, You dont have access to that questionnaire");

				http_response_code(403);

				return;
			}



			/*
				Question Group belongs to Questionnaire
			 */
			if( !$groupBelongsToQuestionnaire )
			{
				/*
					Question Group does not belong to questionnaire
				 */
				$this->setOutput("code", "608");
				$this->setOutput("message", "Not Found, Group doesnt not exist or doesnt belong to questionnaire");

				http_response_code(404);

				return;
			}

			$questionGroup = $questionGroupMapper->findById($groupId);


			
			if( $currentRepeats > $questionGroup->getAllowedRepeats() )
			{
				$this->setOutput("code", "611");
				$this->setOutput("message", "Maximum times of question group replays reached.");

				http_response_code(403);

				return;
			}
			
			if( $groupCompleted )
			{
				$this->setOutput("code", "617");
				$this->setOutput("message", "Forbidden, Group has been completed");

				http_response_code(403);
				return;
			}

			$questionnaire = $questionnaireMapper->findById($questionnaireId);


			if( !$groupHasStarted &&
				 $activeGroups >= 1 &&
				!$questionnaire->getAllowMultipleGroups() )
			{
				$this->setOutput("code", "618");
				$this->setOutput("message", "Forbidden, This questionnaire doesnt allow multiple question group participations");

				http_response_code(403);
				return;
			}			


			if( !$groupHasStarted )
			{
				$currentPriority = $playthroughMapper->findCurrentPriority($userId , $questionnaireId);


				if( $activeGroups==0 && !$playthroughMapper->groupLeftWithPriority($userId , $questionnaireId , $currentPriority) )
					$currentPriority++;

				if( $currentPriority != $questionGroup->getPriority() )
				{
					$this->setOutput("code", "616");
					$this->setOutput("message", "Forbidden, You must complete other question groups first");

					http_response_code(403);
					return;
				}

			}
			else if( $questionGroup->getTimeToComplete()>0 && 
				$playthroughMapper->findTimeLeft($userId , $questionGroup->getId())!== null && 
				$playthroughMapper->findTimeLeft($userId , $questionGroup->getId())<0 )
			{
				$playthroughMapper->setCompleted($userId , $groupId);

				$this->setOutput("code", "617");
				$this->setOutput("message", "Forbidden, Group has been completed");

				http_response_code(403);
				return;		
			}

			/*
				Check question group constraints
			 */
			if( $questionGroupMapper->requiresLocation($groupId) && $questionGroupParticipationMapper->findCount($groupId)>0 )
			{
				$coordinates = $this->getCoordinates();	
				if( $coordinates == null)
				{
					$this->setOutput("code", "606");
					$this->setOutput("message", "Forbidden, Coordinates not provided.");

					http_response_code(403);
	
					return;
				}
				else if( ! ( $questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"]) &&
						     $questionGroupParticipationMapper->participates($userId , $groupId) ) )
				{

					$this->setOutput("code", "607");
					$this->setOutput("message", "Forbidden, Invalid location or user not in participation group.");

					http_response_code(403);
	
					return;
				}
			}
			else if( $questionGroupMapper->requiresLocation($groupId) && $questionGroupParticipationMapper->findCount($groupId)==0 )
			{
				$coordinates = $this->getCoordinates();	
				if( $coordinates == null)
				{
					$this->setOutput("code", "606");
					$this->setOutput("message", "Forbidden, Coordinates not provided.");

					http_response_code(403);
	
					return;
				}
				else if( !$questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"] ) )
				{

					$this->setOutput("code", "607");
					$this->setOutput("message", "Forbidden, Invalid location.");

					http_response_code(403);
	
					return;
				}
			}
			else if( $questionGroupParticipationMapper->findCount($groupId)>0 )
			{
				if( !$questionGroupParticipationMapper->participates($userId , $groupId) )
				{

					$this->setOutput("code", "607");
					$this->setOutput("message", "Forbidden, User not in participation group.");

					http_response_code(403);
	
					return;
				}
			}

			/*
				Get the next question
			 */	
			$question = $questionMapper->findNextQuestion($userId , $groupId);
			$userAnswer = null;

			if($question !== null )
			{
				$timeLeftToAnswer =  $questionMapper->findTimeLeftToAnswer($question->getId() , $userId);

				if( $timeLeftToAnswer!==null && $timeLeftToAnswer <= 0)
				{

					$coordinates = $this->getCoordinates();	

					$userAnswer = new UserAnswer;
					$userAnswer->setUserId($userId);
					$userAnswer->setQuestionId($question->getId());
					$userAnswer->setAnswerId(null);
					$userAnswer->setAnsweredTime($timeLeftToAnswer);
					$userAnswer->setLatitude( $coordinates !== null ? $coordinates["latitude"] : null );
					$userAnswer->setLongitude( $coordinates !== null ? $coordinates["longitude"] : null);
					$userAnswer->setCorrect(0);

					try
					{
						$userAnswerMapper->persist($userAnswer);
					}
					catch(DatabaseException $ex)
					{
						$this->setOutput("code", "500" );
						$this->setOutput("message", "Internal server error." );
						http_response_code(500);
						return;
					}
					
					$question = $questionMapper->findNextQuestion($userId , $groupId);

					if( $question === null )
					{
						$playthroughMapper->setCompleted($userId , $groupId);
						http_response_code(404);
						$this->setOutput("code" , "609");
						$this->setOutput("message" , "Question Group doesnt have any more questions");
						return;
					}
				}

				$answerMapper = new AnswerMapper;

				$answers = $answerMapper->findByQuestion($question->getId());

				// Random order
				shuffle($answers);
				
				$this->setOutput("code", "200");
				$this->setOutput("message", "Success");


				$questionJsonObject["id"] = $question->getId();
				$questionJsonObject["question-text"] = $question->getQuestionText();
				$questionJsonObject["multiplier"] = $question->getMultiplier();
				$questionJsonObject["creation_date"] = $question->getCreationDate();


				if( $timeLeftToAnswer <= -1)
					$questionJsonObject["time-to-answer"] = $question->getTimeToAnswer();
				else
					$questionJsonObject["time-to-answer"] = $timeLeftToAnswer;

				$this->setOutput("question" , $questionJsonObject);

				$answersJsonArray = array();
				foreach ($answers as $answer) 
				{

					$arrayItem["id"] = $answer->getId();
					$arrayItem["answer-text"] = $answer->getAnswerText();
					$arrayItem["creation_date"] = $answer->getCreationDate();
						
					$answersJsonArray[] = $arrayItem;
				}

				$this->setOutput("answer" , $answersJsonArray);

				try
				{

					if( !$playthroughMapper->hasStarted($userId , $groupId) )
						$playthroughMapper->startQuestionGroup($userId , $groupId);

					if( $question->getTimeToAnswer() > 0)
						$questionMapper->addShownRecord($question->getId() , $userId);

				}
				catch(DatabaseException $ex)
				{
					// Ingore , just means this question has been shown recently shown
				}
			}
			else
			{
				$playthroughMapper->setCompleted($userId , $groupId);
				http_response_code(404);
				$this->setOutput("code" , "609");
				$this->setOutput("message" , "Question Group doesnt have any more questions");
			}

		}

	}
