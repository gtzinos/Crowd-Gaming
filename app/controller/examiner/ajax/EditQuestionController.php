<?php
	include_once '../app/model/mappers/questionnaire/QuestionMapper.php';
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/AnswerMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../libs/htmlpurifier-4.7.0/HTMLPurifier.auto.php';

	class EditQuestionController extends Controller
	{
		
		public function init()
		{
			$this->setView( new CodeView );
			
		}

		public function run()
		{

			/*
				Response Code
				0 All ok
				1 Question does not exists
				2 You dont have permission
				3 question-text validation error
				4 time-to-answer validation error
				5 Multiplier validation error
				6 Database Error
				7 Invalid Correct Answer
				8 You cant edit a public questionnaire
			   -1 No data
			 */

			if( isset( $_POST["question-id"] , 
					   $_POST["question-text"] , 
					   $_POST["time-to-answer"] , 
					   $_POST["multiplier"],
					   $_POST["correct"],
					   $_POST["answer1"],
					   $_POST["answer2"]) )
			{
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);

				$participationMapper = new ParticipationMapper;
				$answerMapper = new AnswerMapper;
				$questionMapper = new QuestionMapper;
				$questionnaireMapper = new QuestionnaireMapper;

				$question = $questionMapper->findById($_POST["question-id"] );

				if( $question === null )
				{
					$this->setOutput('response-code' , 1);
					return;
				}

				if( !($participationMapper->participatesInQuestion( $_SESSION["USER_ID"] , $_POST["question-id"] , 2 ) || $_SESSION["USER_LEVEL"]==3) )
				{
					// Invalid Access
					$this->setOutput('response-code' , 2);
					return;
				}

				if( $questionnaireMapper->isGroupPublic($question->getQuestionGroupId()) && $_SESSION["USER_LEVEL"]!=3 )
				{
					// Invalid Access
					$this->setOutput('response-code' , 8);
					return;
				}

				if( strlen( $_POST["question-text"] ) < 2 || strlen($_POST["question-text"] ) >255 )
				{
					$this->setOutput('response-code' , 3);
					return;
				}

				if( !is_numeric($_POST["time-to-answer"]) || $_POST["time-to-answer"]<-1 || $_POST["time-to-answer"] > 180 )
				{
					$this->setOutput('response-code' , 4);
					return;
				} 

				if( !is_numeric($_POST["multiplier"]) || $_POST["multiplier"] <= 0 )
				{
					$this->setOutput('response-code' , 5);
					return;
				}


				$question->setQuestionText( $purifier->purify($_POST["question-text"] ) );
				$question->setMultiplier( $_POST["multiplier"] );
				$question->setTimeToAnswer( $_POST["time-to-answer"] );

				$answers = $answerMapper->findByQuestion( $question->getId() );
				$answersToDelete = array();
				$i = 1;
				// 4 Questinos Max
				for( ; $i < 5 ; $i++ )
				{
					// Answer already exists and post data exist
					if( isset( $answers[$i-1] , $_POST["answer".$i]) )
					{
						if( strlen($_POST["answer".$i]) < 1 && strlen($_POST["answer".$i]) > 255 )
						{
							$this->setOutput('response-code' , 6);
							return;
						}

						$answers[$i-1]->setAnswerText( $_POST["answer".$i] );
						$answers[$i-1]->setCorrect( $_POST["correct"] == $i ? true : false );
					}
					// Answer doesnt exist but post data exist
					else if( !isset( $answers[$i-1]) &&  isset( $_POST["answer".$i]) )
					{
						if( strlen($_POST["answer".$i]) < 1 && strlen($_POST["answer".$i]) > 255 )
						{
							$this->setOutput('response-code' , 6);
							return;
						}

						$answer = new Answer;
						$answer->setAnswerText( $purifier->purify($_POST["answer".$i]) );
						$answer->setCorrect( $_POST["correct"] == $i ? true : false );
						$answer->setQuestionId( $question->getId() );
						$answers[$i-1] = $answer;
					}
					// Answers exists , post data doesnt , Remove answer from db
					else if( isset( $answers[$i-1]) &&  !isset( $_POST["answer".$i]) )
					{
						$answersToDelete[] = $answers[$i-1];
						unset( $answers[$i - 1]);
					}
					else
						break;
					
				}

				if( !is_numeric( $_POST["correct"] ) ||  $_POST["correct"] < 1 || $_POST["correct"] >= $i )
				{
					$this->setOutput('response-code' , 7);
					return;
				}

				try
				{
					DatabaseConnection::getInstance()->startTransaction();
					
					$questionMapper->persist($question);

					foreach ($answers as $answer) 
					{
						$answerMapper->persist($answer);
					}

					foreach ($answersToDelete as $answer) 
					{
						$answerMapper->delete($answer);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 6);
				}

				return;

			}

			$this->setOutput("response-code" , -1);
		}

	}