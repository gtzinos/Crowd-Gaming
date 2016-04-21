<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';

	class GetQuestionController extends AuthenticatedController
	{
		
		public function init()
		{
		}

		public function run()
		{
			$userId = $this->authenticateToken();
			
			$questionnaireId = $this->params[1];
			$groupId = $this->params[3];
			$questionId = null;


			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroupParticipationMapper = new QuestionGroupParticipationMapper;
			$questionMapper = new QuestionMapper;

			$response = array();

		

			/*
				User participates to questionnaire
			 */
			if( !$participationMapper->participates($userId , $questionnaireId , 1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$response["code"] = "403";
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
				$response["code"] = "404";
				$response["message"] = "Not Found, Group doesnt not exist or doesnt belong to questionnaire";

				http_response_code(404);
				print json_encode($response);
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
					$response["code"] = "403";
					$response["message"] = "Forbidden, Coordinates not provided.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
				else if( ! ( $questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"]) &&
						     $questionGroupParticipationMapper->participates($userId , $groupId) ) )
				{

					$response["code"] = "403";
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
					$response["code"] = "403";
					$response["message"] = "Forbidden, Coordinates not provided.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
				else if( !$questionGroupMapper->verifyLocation($groupId , $coordinates["latitude"] , $coordinates["longitude"] ) )
				{

					$response["code"] = "403";
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

					$response["code"] = "403";
					$response["message"] = "Forbidden, User not in participation group.";

					http_response_code(403);
					print json_encode($response);
					return;
				}
			}


			/*
				Get the next question
			 */	
			$question = $questionMapper->findNextQuestion($userId , $groupId);
				
			if($question !== null)
			{
				$answerMapper = new AnswerMapper;

				$answers = $answerMapper->findByQuestion($question->getId());

				$response["code"] = "200";
				$response["message"] = "Success";

				$response["question"]["id"] = $question->getId();
				$response["question"]["question-text"] = $question->getQuestionText();
				$response["question"]["multiplier"] = $question->getMultiplier();
				$response["question"]["creation_date"] = $question->getCreationDate();
				$response["question"]["time-to-answer"] = $question->getTimeToAnswer();
					
				$response["answer"] = array();

				foreach ($answers as $answer) 
				{

					$arrayItem["id"] = $answer->getId();
					$arrayItem["answer-text"] = $answer->getAnswerText();
					$arrayItem["creation_date"] = $answer->getCreationDate();
						
					$response["answer"][] = $arrayItem;
				}

			}
			else
			{

				http_response_code(404);
				$response["code"] = "404";
				$response["message"] = "Question Group doesnt have any more questions";
			}


			print json_encode($response);
		}

	}