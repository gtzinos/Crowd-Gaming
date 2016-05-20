<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class QuestionGroupsController extends Controller
	{

	    public function init()
	    {
	      	global $_CONFIG;

	      	$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$this->defSection('CSS','examiner/QuestionGroupsView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionGroupsView.php');
	      	$this->defSection('MAIN_CONTENT','examiner/QuestionGroupsView.php');
	      	$this->defSection("EDIT_QUESTION" , "examiner/EditQuestionView.php");
	      	$this->defSection("QUESTION_LIST" , "examiner/QuestionListView.php");
	      	$this->defSection("CREATE_QUESTION", "examiner/CreateQuestionView.php");
			$this->defSection("QUESTION_GROUP_USERS", "examiner/QuestionGroupUsersView.php");

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
			$this->setArg("PAGE_TITLE",$questionnaire->getName()." , Handle questionnaire content.");

			$this->setArg( "questionnaire-id" , $questionnaire->getId() );
			$this->setArg( "questionnaire" , $questionnaire );
		}

	}
