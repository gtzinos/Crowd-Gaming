<?php

	/*
		Public pages
	 */
	Routes::add( 'home' , 'public/HomePageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'info' , 'public/InfoPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'contact' , 'public/ContactPageController.php' , $_USER_LEVEL["GUEST"] );
	Routes::add( 'page_not_found' , 'public/PageNotFoundController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'activate' , 'public/ActivationController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'signup-success' , 'public/SignUpSuccessController.php' ,$_USER_LEVEL["GUEST"]);
	Routes::add( 'delete-account-success' , 'public/DeleteAccountSuccessController.php' ,$_USER_LEVEL["GUEST"]);
	Routes::add( 'signin' , 'public/SignInController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'signup' , 'public/SignUpController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'forgot-my-password' , 'public/PasswordRecoveryRequestController.php' , $_USER_LEVEL["GUEST"]);
	Routes::add( 'password-recovery' , 'public/PasswordRecoveryController.php' , $_USER_LEVEL["GUEST"] );

	/*
		Player level pages
	 */
	Routes::add( 'signout' , 'public/SignOutController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'profile' , 'player/ProfilePageController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'confirm_password' , 'player/ConfirmPasswordController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'questionnaireslist' , 'player/QuestionnairesListController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'become-examiner' , 'player/ExaminerApplicationController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'questionnaire' , 'player/QuestionnaireController.php' , $_USER_LEVEL["PLAYER"]);
	Routes::add( 'user' , 'player/UserController.php' , $_USER_LEVEL["PLAYER"] );

	/*
		Examiner level pages
	 */
	Routes::add( 'questionnaire-create' , 'examiner/CreateQuestionnaireController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'questionnaire-edit' , 'examiner/QuestionnaireEditController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'questionnaire-groups' , 'examiner/QuestionnaireGroupsController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'create-questionnaire-groups' , 'examiner/CreateQuestionnaireGroupsController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'questionnaire-workbench' , 'examiner/QuestionnaireWorkbenchController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'questionnaire-schedule' , 'examiner/QuestionnaireScheduleController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'questionnaire-requests' , 'examiner/QuestionnaireRequestsController.php',$_USER_LEVEL["EXAMINER"] );

	/*
		The Page to load when the page parameter is not defined
	*/
	$_CONFIG["DEFAULT_ROUTE"]= "home";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_ROUTE"] = "page_not_found";
