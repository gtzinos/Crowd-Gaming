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
			
			$sort = "date";
			$offset = 0;
			$limit = 10;

			if( isset($_POST["sort"]) && ( $_POST["sort"]=='date' || $_POST["sort"]=='name' || $_POST["sort"]=='pop') )
			{
				$sort = $_POST["sort"];
			}			

			if( isset($_POST["offset"]) && $_POST["offset"] >= 0 )
			{
				$offset = $_POST["offset"];
			}

			if( isset($_POST["limit"]) && $_POST["limit"] >= 0 )
			{
				$limit = $_POST["limit"];
			}


			$questionnaireMapper = new QuestionnaireMapper;

			$questionnaires = null;

			if( $_SESSION["USER_LEVEL"] == 3 )
				$questionnaires = $questionnaireMapper->findAll( $sort , $offset , $limit);
			else
				$questionnaires = $questionnaireMapper->findByCoordinator( $_SESSION["USER_ID"] , $sort , $offset , $limit);

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