<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	
 	class SetQuestionnaireStatusController extends Controller 
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
 				2 : Questionnaire Already public , or already private if "status-code" is "private"
 				3 : Database Error
 				4 : status-code , invalid value
 				-1 : No data
 			 */
 			
 			if( isset( $_POST["questionnaire-id"] , $_POST["status-code"]) )
 			{
 				$questionnaireMapper = new questionnaireMapper;

 				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

 				if( $questionnaire === null )
 				{
 					$this->setOutput("response-code" , 1);
 					return;
 				}

 				if( $_POST["status-code"] != "private" && $_POST["status-code"]!="public" )
 				{
 					$this->setOutput("response-code" , 4);
 					return;
 				}

 				if( ( $_POST["status-code"]=="public" && $questionnaire->getPublic() ) || 
 					( $_POST["status-code"]=="private" && !$questionnaire->getPublic() ) )
 				{
 					$this->setOutput("response-code" , 2);
 					return;
 				}	

 				$questionnaire->setPublic( $_POST["status-code"] == "public" );

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