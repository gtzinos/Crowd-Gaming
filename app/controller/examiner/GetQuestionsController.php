<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetQuestionsController extends Controller{
		
		public function init(){
			$this->setOutputType( OutputType::JsonView );
			
		}

		public function run(){

			if( ! isset( $this->params[1]) ){
				$this->setOutput("response-code" , 1);
				return;
			}

			$questionGroupId = $this->params[1];
			$participationMapper = new ParticipationMapper;

			if( ! $participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $questionGroupId, 2)  ){
				$this->setOutput("response-code" , 2);
				return;
			}


			$questionMapper = new QuestionMapper;

			$questions = $questionMapper->findByQuestionGroup( $questionGroupId );

			$questionsDataArray = array();

			foreach ($questions as $question) {
				$questionsDataArrayItem["id"] = $question->getId();
				$questionsDataArrayItem["group-id"] = $question->getQuestionGroupId();
				$questionsDataArrayItem["question-text"] = $question->getQuestionText();
				$questionsDataArrayItem["time-to-answer"] = $question->getTimeToAnswer();
				$questionsDataArrayItem["creation-date"] = $question->getCreationDate();
				$questionsDataArrayItem["multiplier"] = $question->getMultiplier();

				$questionsDataArray[] = $questionsDataArrayItem;
			}


			$this->setOutput("response-code" , 0);
			$this->setOutput("questions" , $questionsDataArray);

		}
			

	}