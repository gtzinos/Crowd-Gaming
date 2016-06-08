<?php

	include '../core/AppLauncher.php';

	/*
		Application Specific Code that runs
		for every request.

		The $controller object contains the controller that will handle
		this request. It is created by the AppLaucher.php script.
	 */


	/*
		Check if user was banned in the meanwhile
	 */
	if( isset($_SESSION["USER_ID"]) )
	{

		include_once '../app/model/mappers/user/UserMapper.php';

		$userMapper = new UserMapper();

		/*
			force logout the user if he was banned
		 */
		if($userMapper->isBanned($_SESSION["USER_ID"]))
		{
			$user = new User();
			$user->logout();
		}
		else
		{
			// Check if the user level has changed
			$_SESSION["USER_LEVEL"] = $userMapper->findUserLevel($_SESSION["USER_ID"]);
		}
	}


	/*
		Select the correct menus and define View sections that must be loaded for all controllers.
	 */
	if( isset($_SESSION["USER_ID"]) && $controller->getView() instanceof HtmlView )
	{

		$controller->getView()->defSection("CONFIRM_PASSWORD" , "player/ConfirmPasswordModalView.php");


		if( $_SESSION["USER_LEVEL"] == 1)
		{
			$controller->setOutput("primary-menu" , "PlayerMenu");
		}else if( $_SESSION["USER_LEVEL"] == 2)
		{
			$controller->setOutput("primary-menu" , "ExaminerMenu");
		}else if( $_SESSION["USER_LEVEL"] == 3)
		{
			$controller->setOutput("primary-menu" , "ModeratorMenu");
		}

		$controller->setOutput("secondary-menu" , "authorizedRightMenu");
	}
	else if( $controller->getView() instanceof HtmlView  )
	{
		$controller->getView()->defSection("SIGN_IN" , "public/SignInModalView.php");
		$controller->getView()->defSection("SIGN_UP" , "public/SignUpModalView.php");
		$controller->getView()->defSection("PASSWORD_RECOVERY" , "public/PasswordRecoveryRequestModalView.php");

		$controller->setOutput("primary-menu"   , "GuestMenu");
		$controller->setOutput("secondary-menu" , "UnauthorizedRightMenu");
	}


	/*
		This will give control to the controller.
		Dont remove this.
	 */
    $controller->handle();
