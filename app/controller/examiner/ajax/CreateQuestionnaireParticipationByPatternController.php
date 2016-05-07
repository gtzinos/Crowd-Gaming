<?php

	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/user/UserMapper.php';

	class CreateQuestionnaireParticipationByPatternController extends Controller
	{
		public function init()
		{
			$this->setOutputType(OutputType::ResponseStatus);
		}

		public function run()
		{
			/*
				
			 */
			if( isset($_POST["questionnaire-id"] , $_POST["pattern"] , $_POST["participation-type"]) )
			{
				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

				if( $questionnaire === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( ! ( $questionnaire->getCoordinatorId() == $_SESSION["USER_ID"] || $_SESSION["USER_LEVEL"]==3 ) )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				if( $_POST["participation-type"] != 1 && $_POST["participation-type"] != 2 )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				$userMapper = new UserMapper;

				$users = $userMapper->findByPattern($_POST["pattern"] , null);

				$participationMapper = new ParticipationMapper;
				$participations = array();

				foreach ($users as $user) {
					if( !$participationMapper->participates( $user->getId() , $questionnaire->getId() , $_POST["participation-type"]) )
					{
						$participation = new Participation;

						$participation->setUserId( $user->getId() );
						$participation->setQuestionnaireId($questionnaire->getId());
						$participation->setParticipationType($_POST["participation-type"]);

						$participations[] = $participation;
					}
				}

				try
				{
					DatabaseConnection::getInstance()->startTransaction();
					
					foreach ($participations as $participation) {
						$participationMapper->persist($participation);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch( DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 6);
				}
				return;
			}
			$this->setOutput("response-code" , -1);
		}
	}