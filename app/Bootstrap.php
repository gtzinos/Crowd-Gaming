<?php
	
	include '../core/AppLauncher.php';

	/*
		Application Specific Code that runs
		for every request.

		The $controller object contains the controller that will handle
		this request. It is created by the AppLaucher.php script.
	 */


	/*
		Define View sections that must be loaded for all controllers.
	 */
	$controller->defSection("SIGN_IN" , "public/SignInView.php");
	$controller->defSection("SIGN_UP" , "public/SignUpView.php");



	/*
		Select the correct menus
	 */
	if( isset($_SESSION["USER_ID"])){

		if( $_SESSION["USER_LEVEL"] == 1){
			$controller->setArg("primary-menu" , "PlayerMenu");
		}else if( $_SESSION["USER_LEVEL"] == 2){
			$controller->setArg("primary-menu" , "ExaminerMenu");
		}else if( $_SESSION["USER_LEVEL"] == 3){
			$controller->setArg("primary-menu" , "ModeratorMenu");
		}

		$controller->setArg("secondary-menu" , "authorizedRightMenu");
	}else{

		$controller->setArg("primary-menu"   , "GuestMenu");
		$controller->setArg("secondary-menu" , "UnauthorizedRightMenu");	
	}


	/*
		This will give control to the controller.
		Dont remove this.
	 */
    $controller->handle();