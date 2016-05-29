<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireScheduleMapper.php';

	class UserAnswerController extends AuthenticatedController
	{
		
		public function init()
		{
		}

		public function run()
		{
			
			$userId = $this->authenticateToken();
			$response = array();



			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);

			/*
				Check if parameters are set
			 */
			if( !isset($parameters[ "question-id"] , $parameters["answer-id"]) )
			{
				$response["code"] = "610";
				$response["message"] = "Invalid Request, question-id and/or answer-id were not given";

				http_response_code(400);
				print json_encode($response);
				return;
			}

			$participationMapper = new ParticipationMapper;

			if( !$participationMapper->participatesInQuestion($userId , $parameters["question-id"] , 1 , 1))
			{
				/*
					Questionnaire Offline
				 */
				$response["code"] = "603";
				$response["message"] = "Forbidden";

				http_response_code(403);
				print json_encode($response);
				return;
			}
			
		
			$scheduleMapper = new QuestionnaireScheduleMapper;
			$questionnaireMapper = new QuestionnaireMapper;
			
			if($scheduleMapper->findMinutesToStart($questionnaireMapper->findIdByQuestion($parameters["question-id"])) !== 0)
			{
				/*
					Questionnaire Offline
				 */
				$response["code"] = "603";
				$response["message"] = "Forbidden, Questionnaire offline";

				http_response_code(403);
				print json_encode($response);
				return;
			}

			$userAnswerMapper = new UserAnswerMapper;
			$answerMapper = new AnswerMapper;
			$questionMapper = new QuestionMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroupParticipationMapper = new QuestionGroupParticipationMapper;

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
					$response["code"] = "606";
					$response["message"] = "Forbidden, Coordinates not provided.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
				else if( ! ( $questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"]) &&
						     $questionGroupParticipationMapper->participates($userId , $groupId) ) )
				{

					$response["code"] = "607";
					$response["message"] = "Forbidden, Invalid location or user not in participation group.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
			}
			else if( $questionGroupMapper->requiresLocation($groupId) && $questionGroupParticipationMapper->findCount($groupId)==0 )
			{
				$coordinates = $this->getCoordinates();	
				if( $coordinates == null)
				{
					$response["code"] = "606";
					$response["message"] = "Forbidden, Coordinates not provided.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
				else if( !$questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"] ) )
				{

					print $coordinates["latitude"]. ' '. $coordinates["longitude"].'<br>';

					$response["code"] = "607";
					$response["message"] = "Forbidden, Invalid location.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
			}
			else if( $questionGroupParticipationMapper->findCount($groupId)>0 )
			{
				if( !$questionGroupParticipationMapper->participates($userId , $groupId) )
				{

					$response["code"] = "607";
					$response["message"] = "Forbidden, User not in participation group.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
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

					$response["code"] = "200";
					$response["message"] = "All ok , Answer was registered.";
					DatabaseConnection::getInstance()->commit();
				}
				catch(DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					print $e->getMessage();
					$response["code"] = "500";
					$response["message"] = "Internal server error.";
					http_response_code(500);
				}

			}
			else
			{
				$response["code"] = "605";
				$response["message"] = "Forbidden, You cant answer this question";

				http_response_code(403);
			}

			
			print json_encode($response);
		}

	}