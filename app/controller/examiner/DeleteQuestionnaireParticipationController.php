<?php
	
	include_once "../app/model/mappers/questionnaire/QuestionnaireMapper.php";
	include_once "../app/model/mappers/actions/ParticipationMapper.php";

	class DeleteQuestionnaireParticipationController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );	
		}

		public function run()
		{

			/*
				Response Code
				 0 : All ok
				 1 : Questionnaire doesnt exists
				 2 : You must be coordinator
				 3 : participation-type must be 1 or 2
				 4 : The participation doesnt exist
				 5 : You cant remove the coordinator
				 6 : Database Error
				-1 : No post data.
			 */
			if( isset( $_POST["questionnaire-id"] , $_POST["user-id"] , $_POST["participation-type"]) )
			{

				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

				if( $questionnaire === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				if( $questionnaire->getCoordinatorId() == $_POST["user-id"] )
				{
					$this->setOutput("response-code" , 5);
					return;
				}

				if( $_POST["participation-type"] != 1 && $_POST["participation-type"] != 2 )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				$participationMapper = new ParticipationMapper;

				$participation = $participationMapper->findParticipation( $_POST["user-id"] , $questionnaire->getId() , $_POST["participation-type"]);

				if( $participation === null )
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				try
				{
					$participationMapper->delete($participation);	

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $ex)
				{
					$this->setOutput("response-code" , 6); // General database error
				}
				return;
			}

			$this->setOutput("response-code" , -1);
		}
	}