<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetScoreController extends AuthenticatedController{
		
		public function init(){
			$this->setView( new JsonView );
		}

		public function run(){
			$userId = $this->authenticateToken();
			$questionnaireId = $this->params[1];

			$participationMapper = new ParticipationMapper;
			$userAnswerMapper = new UserAnswerMapper;

			$response = array();

			if( !$participationMapper->participates($userId , $questionnaireId , 1 ,1)  ){
				/*
					User doesnt participate to this questionnaire.
				 */
				$response["code"] = "604";
				$response["message"] = "Forbidden, You dont have access to that questionnaire";

				http_response_code(403);
			}else{
				/*
					Return the score for a specific group
				 */
				$score = $userAnswerMapper->findScore($questionnaireId);

				$scoreJson = array();

				foreach ($score as $scoreRow) 
				{
					$jsonItem["user-name"] = $scoreRow["user-name"];
					$jsonItem["user-surname"] = $scoreRow["user-surname"];
					$jsonItem["score"] =  $scoreRow["score"] * 100 / $scoreRow["max-score"];
				
					$scoreJson[ $scoreRow["group-name"] ][] = $jsonItem;
				}

				$response["code"] = "200";
				$response["message"] = "ok";
				$response["score"] = $scoreJson;
			}
		}

	}