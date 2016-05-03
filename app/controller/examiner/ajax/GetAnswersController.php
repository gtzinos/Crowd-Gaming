<?php
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class GetAnswersController extends Controller{

		public function init(){
			$this->setOutputType( OutputType::JsonView );

		}

		public function run(){

			if( ! isset( $this->params[1]) ){
				$this->setOutput("response-code" , 1);
				return;
			}

			$questionId = $this->params[1];
			$participationMapper = new ParticipationMapper;

			if( ! ($participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $questionId, 2) || $_SESSION["USER_LEVEL"]==3)  ){
				$this->setOutput("response-code" , 2);
				return;
			}


			$answerMapper = new AnswerMapper;

			$answers = $answerMapper->findByQuestion( $questionId );

			$answersDataArray = array();

			foreach ($answers as $answer) {
				$answersDataArrayItem["id"] = $answer->getId();
				$answersDataArrayItem["question_id"] = $answer->getQuestionId();
				$answersDataArrayItem["answer_text"] = $answer->getAnswerText();
				$answersDataArrayItem["is_correct"] = $answer->isCorrect();
				$answersDataArrayItem["creation_date"] = $answer->getCreationDate();

				$answersDataArray[] = $answersDataArrayItem;
			}


			$this->setOutput("response-code" , 0);
			$this->setOutput("answers" , $answersDataArray);
		}

	}
