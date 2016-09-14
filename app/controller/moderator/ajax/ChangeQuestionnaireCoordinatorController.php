<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class ChangeQuestionnaireCoordinatorController extends Controller
	{
		public function init()
		{
			$this->setView( new CodeView );
		}

		public function run()
		{

			/*
				Response Codes
				0 : All ok
				1 : Questionnaire does not exist
				2 : User doesnt not exist
				3 : User Access Level is lower than Examiner
				4 : Database Error
				-1: No Data
			 */
			if( isset( $_POST["questionnaire-id"] , $_POST["user-id"] ) )
			{
				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

				if( $questionnaire === null )
				{
					$this->setOutput("response-code", 1);
					return;
				}

				$userMapper = new UserMapper;

				$user = $userMapper->findById($_POST["user-id"]);

				if( $user === null)
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				if( $user->getAccessLevel() < 2)
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				$participationMapper = new ParticipationMapper;
				$examinerParticipation = null;
				$playerParticipation = null;

				if( !$participationMapper->participates($user->getId() , $questionnaire->getId() , 2) )
				{
					$examinerParticipation = new Participation;
					$examinerParticipation->setUserId( $user->getId() );
					$examinerParticipation->setQuestionnaireId( $questionnaire->getId() );
					$examinerParticipation->setParticipationType( 2);
				}

				if( !$participationMapper->participates($user->getId() , $questionnaire->getId() , 1) )
				{
					$playerParticipation = new Participation;
					$playerParticipation->setUserId( $user->getId() );
					$playerParticipation->setQuestionnaireId( $questionnaire->getId() );
					$playerParticipation->setParticipationType( 1);
				}



				$requestMapper = new RequestMapper;

				$playerRequest = $requestMapper->getActivePlayerRequest( $user->getId() , $questionnaire->getId() );
				$examinerRequest = $requestMapper->getActiveExaminerRequest( $user->getId() , $questionnaire->getId() );

				$questionnaire->setCoordinatorId( $user->getId() );

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					if( $examinerParticipation !== null)
						$participationMapper->persist($examinerParticipation);
					if( $playerParticipation !== null )
						$participationMapper->persist($playerParticipation);

					if( $playerRequest !== null )
					{
						$playerRequest->setResponse(true);
						$requestMapper->persist($playerRequest);
					}

					if( $examinerRequest !== null )
					{
						$examinerRequest->setResponse(true);
						$requestMapper->persist($examinerRequest);
					}

					$questionnaireMapper->persist($questionnaire);

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch( DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 4);
				}
				return;
			}

			$this->setOutput("response-code" , -1);
		}
	}
