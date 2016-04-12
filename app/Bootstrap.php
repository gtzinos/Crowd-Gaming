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
	if( isset($_SESSION["USER_ID"]) ){

		include_once '../app/model/mappers/user/UserMapper.php';

		$userMapper = new UserMapper();

		/*
			force logout the user if he was banned
		 */
		if($userMapper->isBanned($_SESSION["USER_ID"])){
			$user = new User();
			$user->logout();
		}else{
			// Check if the user level has changed
			$_SESSION["USER_LEVEL"] = $userMapper->findUserLevel($_SESSION["USER_ID"]);
		}
	}


	/*
		Select the correct menus and define View sections that must be loaded for all controllers.
	 */
	if( isset($_SESSION["USER_ID"])){

		$controller->defSection("CONFIRM_PASSWORD" , "player/ConfirmPasswordView.php");


		if( $_SESSION["USER_LEVEL"] == 1){
			$controller->setArg("primary-menu" , "PlayerMenu");
		}else if( $_SESSION["USER_LEVEL"] == 2){
			$controller->setArg("primary-menu" , "ExaminerMenu");
			$controller->defSection("EDIT_QUESTIONNAIRE", "examiner/QuestionnaireEditView.php");
			$controller->defSection("CREATE_QUESTION", "examiner/CreateQuestion.php");
		}else if( $_SESSION["USER_LEVEL"] == 3){
			$controller->setArg("primary-menu" , "ModeratorMenu");
		}

		$controller->setArg("secondary-menu" , "authorizedRightMenu");
	}else{

		$controller->defSection("SIGN_IN" , "public/SignInView.php");
		$controller->defSection("SIGN_UP" , "public/SignUpView.php");
		$controller->defSection("PASSWORD_RECOVERY" , "public/PasswordRecoveryRequestView.php");


		$controller->setArg("primary-menu"   , "GuestMenu");
		$controller->setArg("secondary-menu" , "UnauthorizedRightMenu");
	}


	/*
		This will give control to the controller.
		Dont remove this.
	 */
    $controller->handle();
