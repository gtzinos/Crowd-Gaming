<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class CopyParticipantsController extends Controller
	{
		public function init()
		{
			$this->setView( new CodeView );
		}

		public function run()
		{


			/*
				Response Code

				0 : All ok
				1 : Participation Type validation error
				2 : FromQuestionnaire Doesnt Exist
				3 : ToQuestionnaire Doesnt Exist
				4 : Invalid Access
			 */
			if( isset( $_POST["from-questionnaire-id"] , $_POST["to-questionnaire-id"] ) )
			{
				if( isset($_POST["participation-type"]) && $_POST["participation-type"] != 1 && $_POST["participation-type"] !=2 )
				{
					$this->setOutput("response-code" , 1);
					return;
				}
				else if ( isset($_POST["participation-type"]) )
				{
					$participationType = $_POST["participation-type"];
				}

				$questionnaireMapper = new QuestionnaireMapper;

				$fromQuestionnaire = $questionnaireMapper->findById( $_POST["from-questionnaire-id"] );

				if( $fromQuestionnaire === null )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				$toQuestionnaire = $questionnaireMapper->findById( $_POST["to-questionnaire-id"] );

				if( $toQuestionnaire === null )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				if( !($_SESSION["USER_LEVEL"]==3 ||
						( $fromQuestionnaire->getCoordinatorId() == $_SESSION["USER_ID"] &&
					  	  $toQuestionnaire->getCoordinatorId() == $_SESSION["USER_ID"] ) ) ) 
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				$participationMapper = new ParticipationMapper;

				$participations = null;

				if( isset($participationType) )
					$participations = $participationMapper->findByQuestionnaire($fromQuestionnaire->getId() , $participationType);
				else
					$participations = $participationMapper->findByQuestionnaire($fromQuestionnaire->getId());

				DatabaseConnection::getInstance()->startTransaction();
				foreach ($participations as $participation) {
					try
					{
						
					
						$participation->setQuestionnaireId( $toQuestionnaire->getId() );
						$participationMapper->persist($participation);
						
						
						
					}
					catch( DatabaseException $e)
					{
						//DatabaseConnection::getInstance()->rollback();
					}
				}
				DatabaseConnection::getInstance()->commit();

				$this->setOutput("response-code" , 0);
				return;
			}

			$this->setOutput("response-code" , -1);

		}
	}