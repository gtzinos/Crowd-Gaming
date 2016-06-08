<?php
	include_once '../app/model/mappers/questionnaire/QuestionnaireMapper.php';
	include_once '../app/model/mappers/questionnaire/QuestionGroupMapper.php';

	class GetAllQuestionGroupsController extends Controller
	{
		
		public function init()
		{
			$this->setView( new JsonView );
		}

		public function run()
		{
			
			/*
				Response Codes
				0 all ok
				1 Questionnaires doesnt exist
				2 You dont have access
			 */
			if( isset($_POST["questionnaire-id"]) )
			{
				$questionnaireMapper = new QuestionnaireMapper;

				$questionnaire = $questionnaireMapper->findById( $_POST["questionnaire-id"] );

				if( $questionnaire === null )
				{
					$this->setOutput("response_code" , 1);
					return;
				}

				if( !( $questionnaire->getCoordinatorId() == $_SESSION["USER_ID"]  || $_SESSION["USER_LEVEL"] == $_USER_LEVEL["EXAMINER"] ) )
				{
					$this->setOutput("response_code" , 2);
					return;
				}

				$questionGroupMapper = new QuestionGroupMapper;

				$groups = $questionGroupMapper->findByQuestionnaire( $questionnaire->getId());

				$groupsJson = array();
				foreach ($groups as $group) 
				{
					$arrayItem["id"] = $group->getId( );
					$arrayItem["questionnaire_id"] = $group->getQuestionnaireId(  );
					$arrayItem["name"] = $group->getName(  );
					$arrayItem["latitude"] = $group->getLatitude( );
					$arrayItem["longitude"] = $group->getLongitude( );
					$arrayItem["radius"] = $group->getRadius(  );
					$arrayItem["creation_date"] = $group->getCreationDate(  );

					$groupsJson[] = $arrayItem;
				}

				$this->setOutput("response_code",0);
				$this->setOutput("groups" , $groupsJson);

			}

		}

	}