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

			$questionnaire = $questionnaireMapper->findById($questionnaireId);

			if( (( $questionnaire->getScoreRights() == 1 && !($participationMapper->participates($userId , $questionnaireId , 1 ,1) || $participationMapper->participates($userId, $questionanireId,2,1)) ) ||
				( $questionnaire->getScoreRights() == 2 && !$participationMapper->participates($userId , $questionnaireId , 2 ,1) ) ||
				( $questionnaire->getScoreRights() == 3 && $questionnaire->getCoordinatorId()!=$userId ))
				&& $this->getUserLevel()<3
			)
			{
				/*
					User doesnt participate to this questionnaire.
				 */
				$this->setOutput("code" , "604" );
				$this->setOutput("message" , "Forbidden" );

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
					$item["user-email"] = $userScore["user-email"];
					$item["score"] = $userScore["score"] * 100 / ( $groups[ $userScore["group-id"] ]["max-score"]);

					$groupScores[$groups[ $userScore["group-id"] ]["name"]][] = $item;
				}


				$sumScore = array();

				foreach ($userScores as $userScore) 
				{
					if( !isset($sumScore[ $userScore["user-id"] ]) )
					{
						$sumScore[ $userScore["user-id"] ]["max-personal-score"] = $questionnaireMapper->GetUserMaxScore($userScore["user-id"],$questionnaireId);
						$sumScore[ $userScore["user-id"] ]["name"] = $userScore["user-name"];
						$sumScore[ $userScore["user-id"] ]["surname"] = $userScore["user-surname"];
						$sumScore[ $userScore["user-id"] ]["email"] = $userScore["user-email"];
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
					if($sum["max-personal-score"] != 0)
					{
						$sumScore[$key]["score"] = $sum["score"] * 100 / $sum["max-personal-score"];
					}
 					else {
						$sumScore[$key]["score"] = 0;
					}
 				}

				$this->setOutput("code" , "200");
				$this->setOutput("message" , "All ok");
				$this->setOutput("group-scores" , $groupScores );
				$this->setOutput("total-score" , $sumScore);
			}
		}

	}
