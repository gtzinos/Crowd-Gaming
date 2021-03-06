<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetGroupsController extends Controller{

		public function init(){

			$this->setHeadless(true);

		}

		public function run(){

			if( !isset($this->params[1] ) ){
				// Invalid Request
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
			}else if( isset( $this->params[3] ) ){

				$count = $this->params[3];
			}

			$participationMapper = new ParticipationMapper;

			if( !( $participationMapper->participates($_SESSION["USER_ID"] , $questionnaireId , 2) || $_SESSION["USER_LEVEL"]==3) ){
				// Invalid Access
				return;
			}

			$questionMapper = new QuestionMapper;
			$questionGroupMapper = new QuestionGroupMapper;

			$questionGroups = $questionGroupMapper->findByQuestionnaireLimited($questionnaireId , $offset , $count);

			foreach ($questionGroups as $questionGroup) {
				$questionGroup->setQuestionCount( $questionMapper->findCountByGroup($questionGroup->getId())  );
			}


			$htmlView = new HtmlView;

			$htmlView->setArg("questionnaire-id" , $questionnaireId);
			$htmlView->setArg("groups" , $questionGroups);
			if(isset($this->params[2])){
				$htmlView->setArg("offset",$this->params[2]);
			}

			$groupHtmlOutput = $htmlView->getViewOutput("examiner/QuestionGroupsView.php" , "QUESTION_GROUP_LIST");

			print $groupHtmlOutput;
		}

	}
