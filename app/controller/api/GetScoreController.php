<?php
	include_once 'AuthenticatedController.php';
	include_once '../app/model/mappers/user/UserAnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/QuestionGroupParticipationMapper.php';

	class GetScoreController extends AuthenticatedController
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			$userId = $this->authenticateToken();
			$questionnaireId = $this->params[1];

			$participationMapper = new ParticipationMapper;
			$userAnswerMapper = new UserAnswerMapper;
			$questionnaireMapper = new QuestionnaireMapper;
			$groupParticipationMapper = new QuestionGroupParticipationMapper;



			if( !$participationMapper->participates($userId , $questionnaireId , 1 ,1)  )
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$this->setOutput("code" , "604" );
				$this->setOutput("message" , "Forbidden, You dont have access to that questionnaire" );

				http_response_code(403);
			}
			else
			{
				
				$groups = $questionnaireMapper->findMaxScore($questionnaireId);
				$userScores = $userAnswerMapper->findScore($questionnaireId);

				$groupScores = array();

				foreach ($userScores as $userScore ) 
				{					
					$item["user-name"] = $userScore["user-name"];
					$item["user-surname"] = $userScore["user-surname"];
					$item["real-score"] = $userScore["score"];
					$item["score"] = $userScore["score"] * 100 / ( $groups[ $userScore["group-id"] ]["max-score"]);

					$groupScores[$groups[ $userScore["group-id"] ]["name"]][] = $item;
				}


				$sumScore = array();

				foreach ($userScores as $userScore) 
				{
					if( isset($sumScore[ $userScore["user-id"] ]) )
					{
						$sumScore[ $userScore["user-id"] ]["score"] += $userScore["score"];
					}
					else
					{
						$sumScore[ $userScore["user-id"] ]["name"] = $userScore["user-name"];
						$sumScore[ $userScore["user-id"] ]["surname"] = $userScore["user-surname"];
						$sumScore[ $userScore["user-id"] ]["score"] = $userScore["score"];
					}
 				}

 				$maxTotalScore = 0;

 				foreach ($groups as $group) 
 				{
 					$maxTotalScore += $group["max-score"];
 				}

 				foreach ($sumScore as $key => $sum) 
 				{
 					$sumScore[$key]["score"] = $sum["score"] * 100 / $maxTotalScore;
 				}

				$this->setOutput("code" , "200");
				$this->setOutput("message" , "All ok");
				$this->setOutput("group-scores" , $groupScores );
				$this->setOutput("total-score" , $sumScore);
			}
		}

	}