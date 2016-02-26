<?php
	

	Routes::add( 'home' , 'public/HomePageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'info' , 'public/InfoPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'contact' , 'public/ContactPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'page_not_found' , 'public/PageNotFoundController.php' , $_USER_LEVEL["GUEST"]);

	Routes::add( 'signin' , 'public/SignInController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'signup' , 'public/SignUpController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'signout' , 'public/SignOutController.php' , $_USER_LEVEL["PLAYER"]);

	Routes::add( 'questionnaires' , 'player/QuestionnairesController.php'  ,$_USER_LEVEL["PLAYER"]);
	Routes::add( 'become-examiner' , 'player/ExaminerApplicationController.php'  ,$_USER_LEVEL["PLAYER"]);

	
	
	/*
		The Page to load when the page parameter is not defined
	*/
	$_CONFIG["DEFAULT_ROUTE"]= "home";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_ROUTE"] = "page_not_found";