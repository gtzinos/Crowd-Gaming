<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';

	class CreateQuestionController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );
		}

		public function run()
		{
			/*
				Response Code
				0 All ok
				1 Invalid Access
				2 question-text validation error
				3 time-to-answer validation error
				4 Multiplier validation error
				5 Database Error
				6 Answer Text validation error
				7 Correct answer error
			   -1 No data
			 */

			if( isset( 	$_POST["question-group-id"] ,
						$_POST["question-text"] , 
						$_POST["time-to-answer"] , 
						$_POST["multiplier"],
						$_POST["answer1"],
						$_POST["answer2"],
						$_POST["answer3"],
						$_POST["answer4"],
						$_POST["correct"] ) )
			{

				$participationMapper = new ParticipationMapper;

				if( !$participationMapper->participatesInGroup( $_SESSION["USER_ID"] , $_POST["question-group-id"] , 2 ) )
				{
					// Invalid Access
					$this->setOutput('response-code' , 1);
					return;
				}

				if( strlen( $_POST["question-text"] ) < 2 || strlen($_POST["question-text"] ) >255 )
				{
					$this->setOutput('response-code' , 2);
					return;
				}

				if( !is_numeric($_POST["time-to-answer"]) || $_POST["time-to-answer"]<5 || $_POST["time-to-answer"] > 180 )
				{
					$this->setOutput('response-code' , 3);
					return;
				} 

				if( !is_numeric($_POST["multiplier"]) || $_POST["multiplier"] <= 0 )
				{
					$this->setOutput('response-code' , 4);
					return;
				}

				if( !is_numeric( $_POST["correct"] ) ||  $_POST["correct"] < 1 || $_POST["correct"] > 4 )
				{
					$this->setOutput('response-code' , 7);
					return;
				}

				$question = new Question;

				$question->setQuestionText( htmlspecialchars($_POST["question-text"] , ENT_QUOTES) );
				$question->setMultiplier( $_POST["multiplier"] );
				$question->setQuestionGroupId( $_POST["question-group-id"] );
				$question->setTimeToAnswer( $_POST["time-to-answer"] );


				$answers = array();

				for( $i= 1 ; $i < 5 ; $i++ )
				{
					if( strlen($_POST["answer".$i]) < 2 && strlen($_POST["answer".$i]) > 255 )
					{
						$this->setOutput('response-code' , 6);
						return;
					}

					$answer = new Answer;
					$answer->setAnswerText( $_POST["answer".$i] );
					$answer->setCorrect( $_POST["correct"] == $i ? true : false );

					$answers[] = $answer;	
				}


				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$questionMapper = new QuestionMapper;
					$answerMapper = new AnswerMapper;

					$questionMapper->persist($question);

					$question->setId( $questionMapper->findLastCreatedId( $question->getQuestionGroupId() ) );

					foreach ($answers as $answer) 
					{
						$answer->setQuestionId( $question->getId() );
						$answerMapper->persist($answer);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{

					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 5);
				}

				return;

			}

			$this->setOutput("response-code" , -1);
		}

	}