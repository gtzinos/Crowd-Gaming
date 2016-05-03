<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetQuestionsController extends Controller{

		public function init(){
			$this->setOutputType( OutputType::JsonView );

		}

		public function run(){

			if( ! isset( $this->params[1]) ){
				$this->setOutput("response_code" , 1);
				return;
			}

			$questionGroupId = $this->params[1];
			$participationMapper = new ParticipationMapper;

			if( ! ($participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $questionGroupId, 2) || $_SESSION["USER_LEVEL"]==3) ){
				$this->setOutput("response_code" , 2);
				return;
			}


			$questionMapper = new QuestionMapper;

			$questions = $questionMapper->findByQuestionGroup( $questionGroupId );

			$questionsDataArray = array();

			foreach ($questions as $question) {
				$questionsDataArrayItem["id"] = $question->getId();
				$questionsDataArrayItem["group_id"] = $question->getQuestionGroupId();
				$questionsDataArrayItem["question_text"] = $question->getQuestionText();
				$questionsDataArrayItem["time_to_answer"] = $question->getTimeToAnswer();
				$questionsDataArrayItem["creation_date"] = $question->getCreationDate();
				$questionsDataArrayItem["multiplier"] = $question->getMultiplier();

				$questionsDataArray[] = $questionsDataArrayItem;
			}


			$this->setOutput("response_code" , 0);
			$this->setOutput("questions" , $questionsDataArray);

		}


	}
