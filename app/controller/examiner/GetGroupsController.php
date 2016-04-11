<?php
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetGroupsController extends Controller{
		
		public function init(){

			$this->setOutputType( OutputType::JsonView ); 
			setContent
		}

		public function run(){

			if( !isset($this->params[1] ) ){
				// Invalid Request
				$this->setOutput("response-status" , 1);
				return;
			}

			$questionnaireId = $this->params[1];

			// Default Values
			$offset = 0;
			$count = 10;

			if( isset( $this->params[2] ,$this->params[3] ) ){

				$offset = $this->params[2];
				$count = $this->params[3];

			}else if( isset( $this->params[2] ) ){

				$offset = $this->params[2];
			}

			$participationMapper = new ParticipationMapper;

			if( ! $participationMapper->participates($_SESSION["USER_LEVEL"] , $questionnaireId , 2) ){
				// Invalid Access
				$this->setOutput("response-status" , 2);
				return;
			}

			$this->setOutput(" response-status" , 0 );

			$questionGroupMapper = new QuestionGroupMapper;

			$questionGroups = $questionGroupMapper->findByQuestionnaireLimited($questionnaireId , $offset , $count);

			$this->setArg("groups" , $questionGroups);

			// Will be linked with appropriate view when done
			$groupHtmlOutput = $this->getViewOutput("examiner/QuestionnaireGroupsView.php" , "MAIN_CONTENT");

			$this->setOutput("html" , $groupHtmlOutput);
		}

	}