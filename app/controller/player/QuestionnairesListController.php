<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class QuestionnairesListController extends Controller{


		public function init(){
			global $_CONFIG;

			$this->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$this->defSection('CSS','player/QuestionnairesListPageView.php');
			$this->defSection('JAVASCRIPT','player/QuestionnairesListPageView.php');
			$this->defSection('MAIN_CONTENT','player/QuestionnairesListPageView.php');
			
			$page = null;

			if( isset($_GET["sort"]) ){
				if($_GET["sort"] == 'name')
					$page = "questionnaireslist/name";
				else if($_GET["sort"] == 'date')
					$page = "questionnaireslist/date";
				else if($_GET["sort"] == 'pop')
					$page = "questionnaireslist/pop";
			}

			if( isset($_GET["page"]) ){
				if( is_numeric($_GET["page"]) ){
					if( $page === null)
						$page = "questionnaireslist/".$_GET["page"];
					else
						$page.= "/".$_GET["page"];
				}
			}

			if( $page !== null)
				$this->redirect($page);

			$this->setArg("PAGE_TITLE","Questionnaires");

		}

		public function run(){
			$sorting = 'date';
			$page = 1;

			if( isset( $this->params[1] , $this->params[2]) ){

				if($this->params[1] == 'name' || $this->params[1] == 'pop')
				{
					$sorting = $this->params[1];
				}

				if( is_numeric($this->params[2]) ){
					$page = $this->params[2];
				}

			}else if( isset($this->params[1]) ){

				if($this->params[1] == 'name' || $this->params[1] == 'pop'){
					$sorting = $this->params[1];
				}
				else if( is_numeric($this->params[1]) ){
					$page = $this->params[1];
				}
			}

			$this->setArg("sort" , $sorting);
			$this->setArg("page" , $page);
			
			$questionnaireMapper = new QuestionnaireMapper;

			/*
				The array items have the below properties
				"questionnaire"  			: the questionnaire object
				"participations" 			: The number of players
				"player-participation" 		: Boolean that shows whether the user participates as a player
				"examiner-participation"	: Boolean that shows whether the user participates as an examiner
				"active-player-request"		: Boolean that shows if the user has an active request to join the questionnaire as Player
				"active-examiner-request" 	: Boolean that shows if the user has an active request to join the questionnaire as Examiner
				access them like this

				$questionnaires[ $key ]["questionnaire"];
			 */
			$questionnaires = null;
			$pagesCount = null;

			if( $_SESSION["USER_LEVEL"] > 1 ){
				/*
					Get all questionnaires
				 */
				$questionnaires = $questionnaireMapper->findWithInfo($sorting , 10 , 10*($page-1) , false );
				$pagesCount = $questionnaireMapper->getNumberOfPages(false);
			}else{
				/*
					Get only public ones
				 */
				$questionnaires = $questionnaireMapper->findWithInfo($sorting , 10 , 10*($page-1) , true);
				$pagesCount = $questionnaireMapper->getNumberOfPages(true);
			}

			

			$this->setArg("pages_count" , $pagesCount);
			$this->setArg("questionnaires" , $questionnaires);

		}

	}
