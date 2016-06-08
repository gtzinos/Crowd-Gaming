<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class QuestionGroupsController extends Controller
	{

	    public function init()
	    {
	      	global $_CONFIG;

	      	$view = new HtmlView;

	      	$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$view->defSection('CSS','examiner/QuestionGroupsView.php');
			$view->defSection('JAVASCRIPT','examiner/QuestionGroupsView.php');
	      	$view->defSection('MAIN_CONTENT','examiner/QuestionGroupsView.php');
	      	$view->defSection("EDIT_QUESTION" , "examiner/EditQuestionModalView.php");
	      	$view->defSection("QUESTION_LIST" , "examiner/QuestionListModalView.php");
	      	$view->defSection("CREATE_QUESTION", "examiner/CreateQuestionModalView.php");
			$view->defSection("QUESTION_GROUP_USERS", "examiner/QuestionGroupUsersModalView.php");

			$this->setView($view);

	    }

		public function run()
		{

			if( !isset( $this->params[1]) )
			{
				$this->redirect("questionnaireslist");
			}

			$participationMapper = new ParticipationMapper;

			if( ! ($participationMapper->participates( $_SESSION["USER_ID"] , $this->params[1] , 2) || $_SESSION["USER_LEVEL"]==3) )
			{
				$this->redirect("questionnaireslist");
			}

			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaire = $questionnaireMapper->findById( $this->params[1] );


			if( $questionnaire === null )
			{
				$this->redirect("questionnaireslist");
			}
			$this->setOutput("PAGE_TITLE",$questionnaire->getName()." , Handle questionnaire content.");

			$this->setOutput( "questionnaire-id" , $questionnaire->getId() );
			$this->setOutput( "questionnaire" , $questionnaire );
		}

	}
