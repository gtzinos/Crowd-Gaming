<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';

	class GetMyQuestionnairesController extends Controller
	{
		
		public function init()
		{
			$this->setOutputType( OutputType::JsonView );
		}

		public function run()
		{
			

			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaires = null;

			if( $_SESSION["USER_LEVEL"] == 3 )
				$questionnaires = $questionnaireMapper->findAll();
			else
				$questionnaires = $questionnaireMapper->findByCoordinator( $_SESSION["USER_ID"]);

			$questionnaireJson = array();

			foreach ($questionnaires as $questionnaire) 
			{
				$arrayItem["id"] = $questionnaire->getId();
				$arrayItem["coordinator_id"] = $questionnaire->getCoordinatorId( );
				$arrayItem["description"] = $questionnaire->getDescription( );
				$arrayItem["name"] = $questionnaire->getName( );
				$arrayItem["public"] = $questionnaire->getPublic( );
				$arrayItem["message_required"] = $questionnaire->getMessageRequired( );
				$arrayItem["creation_date"] = $questionnaire->getCreationDate( );

				$questionnaireJson[] = $arrayItem;
			}

			$this->setOutput("questionnaires" , $questionnaireJson);

		}

	}