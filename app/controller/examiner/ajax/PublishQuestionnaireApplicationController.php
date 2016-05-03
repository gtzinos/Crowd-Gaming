<?php

	include_once "../app/model/mappers/questionnaire/QuestionnaireMapper.php";
	include_once "../app/model/mappers/actions/RequestMapper.php";

	class PublishQuestionnaireApplicationController extends Controller
	{

		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );
		}

		public function run()
		{

			/*
				Response Code

				 1 : Questionnaire doesnt work.
				 2 : You must be coordinator to make the request.
				 3 : Message Validation Error
				 4 : Questionnaire is already public
				 5 : Active application already exists
				 6 : General Database Error
				 7 : There is no active publish application
				-1 : No post data.
			 */
			if( isset( $_POST["questionnaire-id"] , $_POST["cancel"] ) )
			{

				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

				if( $questionnaire === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $questionnaire->getPublic() )
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				if( !($questionnaire->getCoordinatorId() == $_SESSION["USER_ID"] || $_SESSION["USER_LEVEL"]==3 ) )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				$requestMapper = new RequestMapper;
				$request = $requestMapper->getActivePublishRequest($questionnaire->getId() );

				if( $request === null )
				{
					$this->setOutput("response-code" , 7);
					return;
				}


				$request->setResponse(false);

				try
				{
					$requestMapper->persist($request);

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $ex)
				{
					$this->setOutput("response-code" , 6); // General database error
				}
				return;
			}
			else if( isset( $_POST["questionnaire-id"] , $_POST["request-text"]) )
			{

				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById($_POST["questionnaire-id"]);

				if( $questionnaire === null )
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $questionnaire->getPublic() )
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				if( $questionnaire->getCoordinatorId() != $_SESSION["USER_ID"] )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				$requestMapper = new RequestMapper;
				if( $requestMapper->hasActivePublishRequest($questionnaire->getId()) )
				{
					$this->setOutput("response-code" , 5);
					return;
				}

				$requestMessage = htmlspecialchars($_POST["request-text"] , ENT_QUOTES);

				if( strlen($requestMessage)<5 || strlen($requestMessage)>255)
				{
					$this->setOutput("response-code" , 3);
					return;
				}


				$request = new QuestionnaireRequest;

				$request->setUserId( $_SESSION["USER_ID"] );
				$request->setQuestionnaireId( $questionnaire->getId() );
				$request->setRequestType(3);
				$request->setRequestText($requestMessage);

				try
				{
					$requestMapper->persist($request);

					$this->setOutput("response-code" , 0);
				}
				catch(DatabaseException $ex)
				{
					$this->setOutput("response-code" , 6); // General database error
				}
				return;
			}

			$this->setOutput("response-code" , -1);
		}
	}
