<?php
	include_once "../app/model/mappers/questionnaire/QuestionGroupMapper.php";
	include_once "../app/model/mappers/actions/ParticipationMapper.php";
	include_once "../app/model/mappers/questionnaire/QuestionnaireMapper.php";


	class CreateQuestionGroupController extends Controller
	{

		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','examiner/CreateQuestionGroupsView.php');
			$view->defSection('JAVASCRIPT','examiner/CreateQuestionGroupsView.php');
			$view->defSection('MAIN_CONTENT','examiner/CreateQuestionGroupsView.php');

			$view->setArg("PAGE_TITLE","Create a new question group!");

			$this->setView( $view );
		}

		public function run()
		{

			/*
				Response Code
				0 All ok
				1 Group name already exists
				2 Group name validation error
				3 latitude validation error
				4 longitude validation error
				5 radius validation error
				6 Database error
				7 Cant edit a public questionnaire
				8 Invalid allowed_repeats
			 */
			$questionnaireId = null;

			$questionnaireMapper = new QuestionnaireMapper;
			$participationMapper = new ParticipationMapper;
			$questionGroupMapper = new QuestionGroupMapper;

			if( !isset( $this->params[1] ) ||
				$questionnaireMapper->findById($this->params[1]) === null ||
				!($participationMapper->participates( $_SESSION["USER_ID"] , $this->params[1] , 2 ) || $_SESSION["USER_LEVEL"]==3) )
			{

				$this->redirect("questionnaireslist");
			}

			$questionnaireId = $this->params[1];



			$this->setArg("questionnaire-id" , $this->params[1]);


			if( isset( $_POST["name"] , $_POST["latitude"] , $_POST["longitude"] , $_POST["radius"] , $_POST["allowed_repeats"] ) )
			{

				if( $questionGroupMapper->nameExists( $_POST["name"] ) )
				{
					$this->setOutput('response-code' , 1);
					return;
				}

				if( $questionnaireMapper->isPublic($questionnaireId) && $_SESSION["USER_LEVEL"]!=3)
				{
					$this->setOutput('response-code' , 7);
					return;
				}


				if( strlen( $_POST["name"] ) < 2 || strlen($_POST["name"] ) >255 )
				{
					$this->setOutput('response-code' , 2);
					return;
				}

				if( $_POST["allowed_repeats"] < 1 )
				{
					$this->setOutput('response-code' , 8);
					return;
				}

				$questionGroup = new QuestionGroup;

				$questionGroup->setName( htmlspecialchars($_POST["name"] ,ENT_QUOTES) );
				$questionGroup->setQuestionnaireId( $questionnaireId );
				$questionGroup->setAllowedRepeats( $_POST["allowed_repeats"]);

				$questionGroup->setTimeToComplete( isset( $_POST["time-to-complete"])?$_POST["time-to-complete"]:-1);
				$questionGroup->setPriority( isset( $_POST["priority"])?$_POST["priority"]:1);


				if(  !empty( $_POST["latitude"]) && !empty($_POST["longitude"]) && !empty($_POST["radius"]) )
				{
					if( !is_numeric($_POST["latitude"]) || $_POST["latitude"]< -90 || $_POST["latitude"] > 90 )
					{
						$this->setOutput('response-code' , 3);
						return;
					}

					if( !is_numeric($_POST["longitude"]) || $_POST["longitude"]< -180 || $_POST["longitude"] > 180 )
					{
						$this->setOutput('response-code' , 4);
						return;
					}

					if( !is_numeric($_POST["radius"]) || $_POST["radius"]< 5 )
					{
						$this->setOutput('response-code' , 5);
						return;
					}

					$questionGroup->setLatitude( $_POST["latitude"] );
					$questionGroup->setLongitude( $_POST["longitude"] );
					$questionGroup->setRadius( $_POST["radius"] );
				}else{
					$questionGroup->setLatitude( null );
					$questionGroup->setLongitude( null  );
					$questionGroup->setRadius( null  );
				}


				try
				{
					$questionGroupMapper->persist($questionGroup);

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{
					$this->setOutput("response-code" , 6);
				}

				return;

			}


		}

	}
