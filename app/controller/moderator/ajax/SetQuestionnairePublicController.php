<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	
 	class SetQuestionnairePublicController extends Controller 
	{
 		public function init()
 		{
 			$this->setOutputType( OutputType::ResponseStatus );
 		}

 		public function run()
 		{

 			/*
 				Response Codes
 				0 : All ok
 				1 : Questionnaire Doesnt Exist
 				2 : Questionnaire Already public
 				3 : Database Error
 				-1 : No data
 			 */
 			
 			if( isset( $_POST["questionnaire-id"]) )
 			{
 				$questionnaireMapper = new questionnaireMapper;

 				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

 				if( $questionnaire === null )
 				{
 					$this->setOutput("response-code" , 1);
 					return;
 				}

 				if( $questionnaire->getPublic() )
 				{
 					$this->setOutput("response-code" , 2);
 					return;
 				}	

 				$questionnaire->setPublic(true);

 				try
 				{	
 					$questionnaireMapper->persist($questionnaire);
 					
 					$this->setOutput("response-code" , 0);
 				}
 				catch(DatabaseException $ex)
 				{
 					$this->setOutput("response-code" , 3);
 				}

 				return;
 			}

 			$this->setOutput("response-code" , -1);
 		}
 	}