<?php
	
	/*
		Routes

		ORDER MATTERS!!!

		Third parameter is not important. RESTful api should not use session, so $_SESSION["USER_LEVEL"] cant be used.
	 */
	Routes::add( 'invalid_request' , 'api/InvalidRequestController.php' , 0 );
	Routes::add( 'authenticate' , 'api/AuthenticationController.php' , 0 );
	Routes::add( 'questionnaire\/[0-9]+\/group\/[0-9]+\/question' , 'api/GetQuestionController.php' , 0);
	Routes::add( 'questionnaire\/[0-9]+\/group' , 'api/GetQuestionGroupController.php' , 0);
	Routes::add( 'questionnaire' , 'api/GetQuestionnaireController.php' , 0);
	Routes::add( 'answer\/[0-9]+' , 'api/UserAnswerController.php' , 0);
	Routes::add( 'score\/[0-9]+' , 'api/GetScoreController.php' , 0);
	
	/*
		The Page to load when the page parameter is not defined
	*/
	$_CONFIG["DEFAULT_ROUTE"]= "invalid_request";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_ROUTE"] = "invalid_request";
