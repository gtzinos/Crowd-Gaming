<?php
	

	Routes::add( 'home' , 'public/HomePageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'info' , 'public/InfoPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'contact' , 'public/ContactPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'page_not_found' , 'public/PageNotFoundController.php' , $_USER_LEVEL["GUEST"]);


	/*
		The Page to load when the page parameter is not defined
	*/
	$_CONFIG["DEFAULT_ROUTE"]= "home";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_ROUTE"] = "page_not_found";