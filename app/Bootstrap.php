<?php
	
	include '../core/AppLauncher.php';

	/*
		Application Specific Code that runs
		for every request.

		The $controller object contains the controller that will handle
		this request. It is created by the AppLaucher.php script.
	 */

	$controller->defSection("SIGN_IN" , "public/SignInView.php");
	$controller->defSection("SIGN_UP" , "public/SignUpView.php");

	$controller->setArg("primary-menu"   , "GuestMenu");
	$controller->setArg("secondary-menu" , "UnauthorizedRightMenu");


	/*
		This will give control to the controller.
		Dont remove this.
	 */
    $controller->handle();