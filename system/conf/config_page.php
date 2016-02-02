<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	/*
		Define Public Pages
		define_page( Page Title  , Page Codename , ControllerPath , User Level )
	*/
	define_page('Crowd Game', 'home' ,'Public/Home/HomePageController.php' ,$_USER_LEVEL["GUEST"] );	
	define_page('Page not found!' , 'page_not_found' , "Public/NotFound/PageNotFoundController.php" , $_USER_LEVEL["GUEST"]);
 	


	/*
		The Page to load when none is given
	*/	
	$_CONFIG["DEFAULT_PAGE"]= "home";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_PAGE"] = "page_not_found";