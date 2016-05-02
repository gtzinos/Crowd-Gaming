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
	Routes::add( 'questionnaire-groups' , 'examiner/QuestionnaireGroupsController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'edit-question-group' , 'examiner/EditQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'questionnaire-schedule' , 'examiner/QuestionnaireScheduleController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'questionnaire-requests' , 'examiner/QuestionnaireRequestsController.php',$_USER_LEVEL["EXAMINER"] );
	Routes::add( 'create-question-group' , 'examiner/CreateQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"]);
	
	// Ajax
	Routes::add( 'questionnaire-edit' , 'examiner/ajax/QuestionnaireEditController.php' , $_USER_LEVEL["EXAMINER"]); 
	Routes::add( 'get-question-groups' , 'examiner/ajax/GetGroupsController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'get-questions' , 'examiner/ajax/GetQuestionsController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'get-answers' , 'examiner/ajax/GetAnswersController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'create-question'  , 'examiner/ajax/CreateQuestionController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'edit-question' , 'examiner/ajax/EditQuestionController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'edit-answer' , 'examiner/ajax/EditAnswerController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'delete-question' , 'examiner/ajax/DeleteQuestionController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'delete-question-group' , 'examiner/ajax/DeleteQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'delete-questionnaire' , 'examiner/ajax/DeleteQuestionnaireController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'add-user-to-question-group' , 'examiner/ajax/AddUserToQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'remove-user-from-question-group' , 'examiner/ajax/RemoveUserFromQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'get-users-from-question-group' , 'examiner/ajax/GetUsersFromQuestionGroupController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'publish-questionnaire-request' , 'examiner/ajax/PublishQuestionnaireApplicationController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'delete-questionnaire-participation' , 'examiner/ajax/DeleteQuestionnaireParticipationController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'create-questionnaire-participation' , 'examiner/ajax/CreateQuestionnaireParticipationController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'handle-questionnaire-request' , "examiner/ajax/HandleQuestionnaireRequestController.php" , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'get-users-from-questionnaire' , 'examiner/ajax/GetUsersFromQuestionnaireController.php' , $_USER_LEVEL["EXAMINER"] ); 
	Routes::add( 'get-all-question-groups' , 'examiner/ajax/GetAllQuestionGroupsController.php' ,$_USER_LEVEL["EXAMINER"]);
	Routes::add( 'get-my-questionnaires' , 'examiner/ajax/GetMyQuestionnairesController.php' , $_USER_LEVEL["EXAMINER"] );
	Routes::add( 'get-users-by-pattern' , 'examiner/ajax/GetUsersByPatternController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'copy-participants' , 'examiner/ajax/CopyParticipantsController.php' , $_USER_LEVEL["EXAMINER"]);
	Routes::add( 'get-questionnaire-requests' , 'examiner/ajax/GetQuestionnaireRequests.php' , $_USER_LEVEL["EXAMINER"]);
	/*
		Moderator level pages
	 */
	
	//Ajax
	Routes::add( 'handle-questionnaire-public-request' , 'moderator/ajax/HandleQuestionnaireRequestController.php' , $_USER_LEVEL["MODERATOR"] );
	Routes::add( 'handle-examiner-application' , 'moderator/ajax/HandleExaminerApplicationController.php' , $_USER_LEVEL["MODERATOR"] );
	Routes::add( 'ban-user' , 'moderator/ajax/BanUserController.php' , $_USER_LEVEL["MODERATOR"] );
	Routes::add( 'ban-examiners-from-questionnaire' , 'moderator/ajax/BanExaminersController.php' , $_USER_LEVEL["MODERATOR"]);
	Routes::add( 'update-user-profile' , 'moderator/ajax/UpdateUserProfileController.php' , $_USER_LEVEL["MODERATOR"] );
	Routes::add( 'change-coordinator' , 'moderator/ajax/ChangeQuestionnaireCoordinatorController.php' , $_USER_LEVEL["MODERATOR"] );
	Routes::add( 'get-publish-requests' , 'moderator/ajax/GetPublishRequestsController.php' , $_USER_LEVEL["MODERATOR"]);
	Routes::add( 'set-questionnaire-public' , 'moderator/ajax/SetQuestionnairePublicController.php' , $_USER_LEVEL["MODERATOR"] );

	/*
		The Page to load when the page parameter is not defined
	*/
	$_CONFIG["DEFAULT_ROUTE"]= "home";
	/*
		The Page to load when the requested page does not exist
	*/
	$_CONFIG["404_ROUTE"] = "page_not_found";
