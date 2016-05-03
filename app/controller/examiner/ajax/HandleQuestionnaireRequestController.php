<?php
	include_once '../app/model/mappers/actions/ParticipationMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/actions/RequestMapper.php';

	class HandleQuestionnaireRequestController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::ResponseStatus );			
		}

		public function run()
		{

			/*
				Response Code

				 0 : All ok
				 1 : Request does not exists
				 2 : You can only handle player or examiner requests.
				 3 : You dont have access to this questionnaire
				 4 : response must be either "accept" or "decline"
				 5 : Response already handled
				 6 : General Database Error
				-1 : No data
			 */
			if( isset( $_POST["request-id"] , $_POST["response"]) )
			{
				$requestMapper = new RequestMapper;

				$request = $requestMapper->findById($_POST["request-id"]);

				if( $request === null)
				{
					$this->setOutput("response-code" , 1);
					return;
				}

				if( $request->getRequestType() != 1 && $request->getRequestType() !=2 )
				{
					$this->setOutput("response-code" , 2);
					return;
				}

				if( $request->getResponse() !== null )
				{
					$this->setOutput("response-code" , 5);
					return;
				}

				$participationMapper = new ParticipationMapper;

				if( !($participationMapper->participates($_SESSION["USER_ID"] , $request->getQuestionnaireId() , 2 )|| $_SESSION["USER_LEVEL"]==3) )
				{
					$this->setOutput("response-code" , 3);
					return;
				}

				if( $_POST["response"] != "accept" && $_POST["response"] != "decline")
				{
					$this->setOutput("response-code" , 4);
					return;
				}

				$request->setResponse( $_POST["response"] == "accept" ? true : false );

				try
				{
					DatabaseConnection::getInstance()->startTransaction();

					$requestMapper->persist($request);

					if( $request->getResponse() )
					{
						$participation = new Participation;
						$participation->setUserId( $request->getUserId() );
						$participation->setQuestionnaireId( $request->getQuestionnaireId() );
						$participation->setParticipationType( $request->getRequestType() );

						$participationMapper->persist($participation);
					}

					DatabaseConnection::getInstance()->commit();
					$this->setOutput("response-code" , 0);
				}
				catch( DatabaseException $e)
				{
					DatabaseConnection::getInstance()->rollback();
					$this->setOutput("response-code" , 6);
				}

				return;
			}		

			$this->setOutput("response-code" , -1);
		}

	}