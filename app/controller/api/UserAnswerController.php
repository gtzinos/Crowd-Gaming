<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/PlaythroughMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class UserAnswerController extends AuthenticatedController
	{

		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{

			$userId = $this->authenticateToken();

			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);


			//MAPPERS
			$scheduleMapper = new QuestionnaireScheduleMapper;
			$questionnaireMapper = new QuestionnaireMapper;
			$userAnswerMapper = new UserAnswerMapper;
			$answerMapper = new AnswerMapper;
			$questionMapper = new QuestionMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroupParticipationMapper = new QuestionGroupParticipationMapper;
			$participationMapper = new ParticipationMapper;
			$playthroughMapper = new PlaythroughMapper;



			/*
				Check if parameters are set
			 */
			if( !isset($parameters[ "question-id"] , $parameters["answer-id"]) )
			{
				$this->setOutput("code", "610" );
				$this->setOutput("message", "Invalid Request, question-id and/or answer-id were not given" );

				http_response_code(400);
				return;
			}



			if( !$participationMapper->participatesInQuestion($userId , $parameters["question-id"] , 1 , 1))
			{
				/*
					Questionnaire Offline
				 */
				$this->setOutput("code", "603" );
				$this->setOutput("message", "Forbidden" );

				http_response_code(403);
				return;
			}




			if($scheduleMapper->findMinutesToStart($questionnaireMapper->findIdByQuestion($parameters["question-id"])) != 0)
			{
				/*
					Questionnaire Offline
				 */
				$this->setOutput("code", "603" );
				$this->setOutput("message", "Forbidden, Questionnaire offline" );

				http_response_code(403);
				return;
			}



			$question = $questionMapper->findById( $parameters["question-id"] );
			$groupId = $question->getQuestionGroupId();

			$coordinates = null;
			/*
				Check question group constraints
			 */
			if( $questionGroupMapper->requiresLocation($groupId) && $questionGroupParticipationMapper->findCount($groupId)>0 )
			{
				$coordinates = $this->getCoordinates();
				if( $coordinates == null)
				{
					$this->setOutput("code", "606" );
					$this->setOutput("message", "Forbidden, Coordinates not provided." );

					http_response_code(403);
					return;
				}
				else if( ! ( $questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"]) &&
						     $questionGroupParticipationMapper->participates($userId , $groupId) ) )
				{

					$this->setOutput("code", "607" );
					$this->setOutput("message", "Forbidden, Invalid location or user not in participation group." );

					http_response_code(403);
					return;
				}
			}
			else if( $questionGroupMapper->requiresLocation($groupId) && $questionGroupParticipationMapper->findCount($groupId)==0 )
			{
				$coordinates = $this->getCoordinates();
				if( $coordinates == null)
				{
					$this->setOutput("code", "606" );
					$this->setOutput("message", "Forbidden, Coordinates not provided." );

					http_response_code(403);
					return;
				}
				else if( !$questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"] ) )
				{

					print $coordinates["latitude"]. ' '. $coordinates["longitude"].'<br>';

					$this->setOutput("code", "607" );
					$this->setOutput("message", "Forbidden, Invalid location." );

					http_response_code(403);
					return;
				}
			}
			else if( $questionGroupParticipationMapper->findCount($groupId)>0 )
			{
				if( !$questionGroupParticipationMapper->participates($userId , $groupId) )
				{

					$this->setOutput("code", "607" );
					$this->setOutput("message", "Forbidden, User not in participation group." );

					http_response_code(403);
					return;
				}
			}


			$questionGroup = $questionGroupMapper->findById($groupId);


			// Variables
			$groupHasStarted = $playthroughMapper->hasStarted($userId ,$groupId);
			$timeLeftToStart = $scheduleMapper->findMinutesToStart($questionGroup->getQuestionnaireId());
			$participates = $participationMapper->participates($userId , $questionGroup->getQuestionnaireId() , 1 ,1);
			$groupBelongsToQuestionnaire = $questionGroupMapper->groupBelongsTo($groupId , $questionGroup->getQuestionnaireId());
			$currentRepeats = $playthroughMapper->findRepeatCount($userId , $groupId);
			$groupCompleted = $playthroughMapper->isCompleted($userId ,$groupId);
			$activeGroups = $playthroughMapper->findActiveGroupCount($userId, $questionGroup->getQuestionnaireId());

			$questionnaire = $questionnaireMapper->findById($questionGroup->getQuestionnaireId());

			if( !$groupHasStarted &&
				 $activeGroups >= 1 &&
				!$questionnaire->getAllowMultipleGroups() )
			{
				$this->setOutput("code", "607");
				$this->setOutput("message", "Forbidden, This questionnaire doesnt allow multiple question group participations");

				http_response_code(403);
				return;
			}


			if( !$groupHasStarted )
			{
				$currentPriority = $playthroughMapper->findPriority($userId , $questionnaire->getId());

				if( $currentPriority != $questionGroup->getPriority() )
				{
					$this->setOutput("code", "607");
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

				$this->setOutput("code", "607");
				$this->setOutput("message", "Forbidden, Group has been completed now");

				http_response_code(403);
				return;
			}

			/*
				Check if the user can answer this question and if the answer he choose belongs to that question
			 */

			if( $userAnswerMapper->canAnswer($parameters[ "question-id"] , $userId ,$groupId) &&
				( $parameters["answer-id"] =="null" ||
					$answerMapper->answerBelongsToQuestion($parameters["answer-id"] , $parameters["question-id"]) ) )
			{

				/*
					Create the object
				 */
				$userAnswer = new UserAnswer;

				$userAnswer->setUserId($userId);
				$userAnswer->setQuestionId($parameters[ "question-id"]);
				$userAnswer->setAnswerId($parameters["answer-id"]!="null"?$parameters["answer-id"]:null);
				$userAnswer->setAnsweredTime(0); // Whatever , who cares
				$userAnswer->setLatitude( $coordinates !== null ? $coordinates["latitude"] : null );
				$userAnswer->setLongitude( $coordinates !== null ? $coordinates["longitude"] : null);
				$userAnswer->setCorrect( $answerMapper->isCorrect( $parameters["answer-id"])
										 && $questionMapper->isAnsweredInTime( $parameters[ "question-id"] , $userId ) );

				/*
					Try to insert it in the database
				 */
				try
				{
					DatabaseConnection::getInstance()->startTransaction();
					$userAnswerMapper->persist($userAnswer);
					$questionMapper->deleteQuestionShownRecords($groupId , $userId);


					if ( $questionMapper->findNextQuestion($userId,$groupId) === null )
					{
						$playthroughMapper->setCompleted( $userId , $groupId);

						$this->setOutput("code", "201" );
						$this->setOutput("message", "All ok , Answer was registered. Question Group Completed" );

					}
					else
					{
						$this->setOutput("code", "200" );
						$this->setOutput("message", "All ok , Answer was registered." );
					}

					DatabaseConnection::getInstance()->commit();
				}
				catch(DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("code", "500" );
					$this->setOutput("message", "Internal server error." );
					http_response_code(500);
				}

			}
			else
			{
				$this->setOutput("code", "605" );
				$this->setOutput("message", "Forbidden, You cant answer this question" );

				http_response_code(403);
			}

		}

	}
