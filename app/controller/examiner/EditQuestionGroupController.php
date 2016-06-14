<?php
	include_once "../app/model/mappers/questionnaire/QuestionGroupMapper.php";
	include_once "../app/model/mappers/questionnaire/QuestionnaireMapper.php";
	include_once "../app/model/mappers/actions/ParticipationMapper.php";

	class EditQuestionGroupController extends Controller
	{


		public function init()
		{
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('JAVASCRIPT','examiner/EditQuestionGroupView.php');
			$view->defSection('MAIN_CONTENT','examiner/EditQuestionGroupView.php');

			$view->setArg("PAGE_TITLE","Modify a question group!");

			$this->setView($view);
		}

		public function run()
		{


			if( !isset( $this->params[1] ) )
			{
				$this->redirect("questionnaireslist");
			}

			$groupId = $this->params[1];

			$participationMapper = new ParticipationMapper;

			if( ! ( $participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $groupId , 2) || $_SESSION["USER_LEVEL"]==3 ) )
			{
				$this->redirect("questionnaireslist");
			}

			$questionGroupMapper = new QuestionGroupMapper;
			$questionGroup = $questionGroupMapper->findById( $groupId );

			if( $questionGroup === null )
			{
				$this->redirect("questionnaireslist");
			}

			$this->setOutput("question-group" , $questionGroup);


			/*
				Post Request Handling , Edit Question
				
				Response Code
				0 All ok
				1 Group name already exists
				2 Group name validation error
				3 latitude validation error
				4 longitude validation error
				5 radius validation error
				6 Database error
				7 Cant Edit a public Questionnaire
				8 Invalid allowed repeats
			 */
			if( isset( $_POST["name"] , $_POST["latitude"] , $_POST["longitude"] , $_POST["radius"] , $_POST["allowed_repeats"]) )
			{
				$questionnaireMapper = new QuestionnaireMapper;
				if( $questionnaireMapper->isGroupPublic($groupId) && $_SESSION["USER_LEVEL"]!=3)
				{
					$this->setOutput('response-code' , 7);
					return;
				}


				$name = htmlspecialchars($_POST["name"] ,ENT_QUOTES);


				if( $questionGroup->getName()!=$name && $questionGroupMapper->nameExists( $name ) ) 
				{
					$this->setOutput('response-code' , 1);
					return;
				}


				if( strlen( $name ) < 2 || strlen($name ) >255 )
				{
					$this->setOutput('response-code' , 2);
					return;
				}

				if( $_POST["allowed_repeats"] < 1 )
				{
					$this->setOutput('response-code' , 8);
					return;
				}

				$questionGroup->setName( $name );				
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
			}

		}

	}
