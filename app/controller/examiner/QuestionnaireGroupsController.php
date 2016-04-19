<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class QuestionnaireGroupsController extends Controller{

	    public function init(){
	      	global $_CONFIG;

	      	$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);
			$this->defSection('CSS','examiner/QuestionnaireGroupsView.php');
			$this->defSection('JAVASCRIPT','examiner/QuestionnaireGroupsView.php');
	      	$this->defSection('MAIN_CONTENT','examiner/QuestionnaireGroupsView.php');
	      	$this->defSection("EDIT_QUESTION" , "examiner/EditQuestionView.php");
	      	$this->defSection("QUESTION_LIST" , "examiner/QuestionListView.php");
	      	$this->defSection("CREATE_QUESTION", "examiner/CreateQuestionView.php");
	    }

		public function run(){

			if( !isset( $this->params[1]) ){
				$this->redirect("questionnaireslist");
			}

			$participationMapper = new ParticipationMapper;

			if( ! $participationMapper->participates( $_SESSION["USER_ID"] , $this->params[1] , 2) ){
				$this->redirect("questionnaireslist");
			}

			$this->setArg( "questionnaire-id" , $this->params[1] );

		}

	}
