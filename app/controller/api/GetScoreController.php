<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetScoreController extends AuthenticatedController{
		
		public function init(){
		}

		public function run(){
			$userId = $this->authenticateToken();
			$questionnaireId = $this->params[1];
			$questionGroupId = null;

			if(isset($this->params[2]) )
				$questionGroupId = $this->params[2];

			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;
			$userAnswerMapper = new UserAnswerMapper;

			$response = array();

			if( !$participationMapper->participates($userId , $questionnaireId , 1)  ){
				/*
					User doesnt participate to this questionnaire.
				 */
				$response["code"] = "604";
				$response["message"] = "Forbidden, You dont have access to that questionnaire";

				http_response_code(403);

			}else if( $questionGroupId === null ){
				/*
					Return the score for all the groups
				 */
				
				$score = $userAnswerMapper->findQuestionnaireScore($userId,$questionnaireId);

				$response["code"] = "200";
				$response["message"] = "ok";
				$response["score"] = $score;

			}else{
				/*
					Return the score for a specific group
				 */
				$score = $userAnswerMapper->findQuestionGroupScore($userId,$questionGroupId);

				$response["code"] = "200";
				$response["message"] = "ok";
				$response["score"] = $score;
			}


			print json_encode($response);
		}

	}