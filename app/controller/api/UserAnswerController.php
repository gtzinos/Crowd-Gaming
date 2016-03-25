<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';

	class UserAnswerController extends AuthenticatedController{
		
		public function init(){
		}

		public function run(){
			
			$userId = $this->authenticateToken();
			$coordinates = $this->getCoordinates();		

			$response = array();

			/*
				Check if coordinates were given
			 */
			if( $coordinates == null){
				$response["code"] = "403";
				$response["message"] = "Forbidden, Coordinates not provided.";

				http_response_code(403);
				print json_encode($response);
				return;
			}

			$httpBody = file_get_contents('php://input');
			$parameters = json_decode($httpBody,true);

			/*
				Check if parameters are set
			 */
			if( !isset($parameters[ "question-id"] , $parameters["answer-id"] , $parameters["time-answered"]) ){
				$response["code"] = "400";
				$response["message"] = "Invalid Request, question-id and/or answer-id were not given";

				http_response_code(400);
				print json_encode($response);
				return;
			}
			
			$userAnswerMapper = new UserAnswerMapper;
			$answerMapper = new AnswerMapper;

			/*
				Check if the user can answer this question and if the answer he choose belong to that question
			 */
			if( $userAnswerMapper->canAnswer($parameters[ "question-id"] , $userId , $coordinates["latitude"] , $coordinates["longitude"]) && $answerMapper->answerBelongsToQuestion($parameters["answer-id"] , $parameters["question-id"])){

				/*
					Create the object
				 */
				$userAnswer = new UserAnswer;

				$userAnswer->setUserId($userId);
				$userAnswer->setQuestionId($parameters[ "question-id"]);
				$userAnswer->setAnswerId($parameters["answer-id"]);
				$userAnswer->getAnsweredTime($parameters["time-answered"]);
				$userAnswer->setLatitude($coordinates["latitude"]);
				$userAnswer->setLongitude($coordinates["longitude"]);

				/*
					Try to insert it in the database
				 */
				try{
					
					$userAnswerMapper->persist($userAnswer);

					$response["code"] = "200";
					$response["message"] = "All ok , Answer was registered.";

				}catch(DatabaseException $e){
					$response["code"] = "500";
					$response["message"] = "Internal server error.";
					http_response_code(500);
				}

			}else{
				$response["code"] = "403";
				$response["message"] = "Forbidden, You cant answer this question";

				http_response_code(403);
			}

			
			print json_encode($response);
		}

	}