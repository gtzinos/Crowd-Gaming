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
				$this->setView( new JsonView);
			}
			else
			{

				global $_CONFIG;

				$view = new HtmlView;

				$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

				$view->defSection('CSS','examiner/CreateQuestionnaireView.php');
				$view->defSection('JAVASCRIPT','examiner/CreateQuestionnaireView.php');
				$view->defSection('MAIN_CONTENT','examiner/CreateQuestionnaireView.php');

				$view->setArg("PAGE_TITLE","Create a new Questionnaire!");

				$this->setView($view);

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
				3			: Password Required Error
				4			: Database Error
				5			: Name already exists
			 */

			if( isset($this->params[1], $_POST["name"] ,  $_POST["description"] , $_POST["message_required"] , $_POST["allow-multiple-groups-playthrough"]) && $this->params[1]=="ajax" )
			{
				$this->setOutput("response-code" , -1);
				$questionnaireMapper = new QuestionnaireMapper;

				$name = htmlspecialchars($_POST["name"] , ENT_QUOTES);

				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$description = $purifier->purify($_POST["description"]);

				$messageRequired = $_POST["message_required"];

				$message = NULL;

				if( isset($_POST["message"]) && strlen($_POST["message"])<255)
				{
					$message = htmlspecialchars($_POST["message"]);
				}


				if( strlen($name) < 3 )
				{

					$this->setOutput("response-code" , 1); // Name Validation error

				}
				else if(  $questionnaireMapper->nameExists( $name ) )
				{
					$this->setOutput("response-code" , 5); // Name already exists
				}
				else if( strlen($description) < 30 )
				{

					$this->setOutput("response-code" , 2); // Descriptin validation error

				}
				else if( $messageRequired != "no" && $messageRequired != "yes")
				{

					$this->setOutput("response-code" , 3); // Password required error

				}
				else
				{

					$questionnaire = new Questionnaire;

					$questionnaire->setName( $name );
					$questionnaire->setDescription( $description );
					$questionnaire->setMessageRequired( $messageRequired=="yes" ? true : false );
					$questionnaire->setPublic( false );
					$questionnaire->setMessage( $message);
					$questionnaire->setCoordinatorId( $_SESSION["USER_ID"] );
					$questionnaire->setAllowMultipleGroups( $_POST["allow-multiple-groups-playthrough"]=="1"?1:0);

					if( isset($_POST["score_rights"]) && ($_POST["score_rights"]>=1 && $_POST["score_rights"]<=3 ) )
					{
						$questionnaire->setScoreRights($_POST["score_rights"]);
					}
					else
					{
						$questionnaire->setScoreRights(3);
					}

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
						$this->setOutput("response-code" , 0); // All ok
						$this->setOutput("questionnaire-id" , $questionnaireId);

					}
					catch(DatabaseException $ex)
					{
						
						DatabaseConnection::getInstance()->rollback();
						$this->setOutput("response-code" , 4); // Database Error
					}
				}
			}


		}

	}
