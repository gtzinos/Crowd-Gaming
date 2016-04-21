<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

	class CreateQuestionnaireController extends Controller
	{
		
		public function init()
		{
			if( isset($this->params[1]) && $this->params[1]=="ajax")
			{
				$this->setHeadless(true);
			}
			else
			{
				global $_CONFIG;

				$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

				$this->defSection('CSS','examiner/CreateQuestionnaireView.php');
				$this->defSection('JAVASCRIPT','examiner/CreateQuestionnaireView.php');
				$this->defSection('MAIN_CONTENT','examiner/CreateQuestionnaireView.php');
			}			
		}

		public function run()
		{

			/*
				Response Codes (Ajax)
				not set 	: User didnt request questionnaire creation
				0			: Created successfully
				1			: Name Validation error
				2			: Description Validation error
				3			: Message Required Error
				4			: Database Error
				5			: Name already exists
			 */
			
			if( isset($this->params[1], $_POST["name"] ,  $_POST["description"] , $_POST["message_required"] ) && $this->params[1]=="ajax" )
			{

				$questionnaireMapper = new QuestionnaireMapper;

				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);

				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);

				$messageRequired = $_POST["message_required"];

				if( strlen($name) < 3 )
				{
					
					print 1; // Name Validation error

				}
				else if(  $questionnaireMapper->nameExists( $name ) )
				{
					print 5; // Name already exists
				}
				else if( strlen($description) < 30 )
				{
					
					print 2; // Descriptin validation error

				}
				else if( $messageRequired != "no" && $messageRequired != "yes")
				{

					print 3; // Message required error

				}
				else
				{

					$questionnaire = new Questionnaire;

					$questionnaire->setName( $name );
					$questionnaire->setDescription( $description );
					$questionnaire->setMessageRequired( $messageRequired=="yes" ? true : false );
					$questionnaire->setPublic( false );
					$questionnaire->setCoordinatorId( $_SESSION["USER_ID"] );


					$examinerParticipation = new Participation;
					$examinerParticipation->setUserId( $_SESSION["USER_ID"]);
					$examinerParticipation->setParticipationType( 2 );

					$playerParticipation = new Participation;
					$playerParticipation->setUserId( $_SESSION["USER_ID"]);
					$playerParticipation->setParticipationType( 1 );

					
					$participationMapper = new ParticipationMapper;

					try
					{
						DatabaseConnection::getInstance()->startTransaction();


						$questionnaireMapper->persist($questionnaire);	

						$questionnaireId = $questionnaireMapper->findLastCreateId($_SESSION["USER_ID"]);

						if( $questionnaireId  == -1 )
							throw new DatabaseException();

						$examinerParticipation->setQuestionnaireId( $questionnaireId );
						$playerParticipation->setQuestionnaireId( $questionnaireId );


						$participationMapper->persist($examinerParticipation);
						$participationMapper->persist($playerParticipation);

						DatabaseConnection::getInstance()->commit();
						print 0; // All ok

					}
					catch(DatabaseException $ex)
					{
						
						DatabaseConnection::getInstance()->rollback();
						print 4; // Database Error
					}
				}
			}


		}

	}