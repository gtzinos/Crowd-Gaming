<?php
	/*
		Menus

		menu_add_item( Name of Menu , The codename of the page , Order , Label );
	*/


	/*
		Main menu that will show when a user that has not logged in.
	 */
	$guestMenu = Menu::create("GuestMenu");

	$guestMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );
	$guestMenu->addItem( MenuItem::create("Info" , "LINK" , "info") );
	$guestMenu->addItem( MenuItem::create("Contact" , "LINK" , "contact") );


	/*
		Player Menu
	 */
	$playerMenu = Menu::create("PlayerMenu");

	$playerMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );
	$playerMenu->addItem( MenuItem::create("Questionnaires" , "LINK" , "questionnaireslist") );
	$playerMenu->addItem( MenuItem::create("Become an Examiner" , "LINK" , "become-examiner") );
	$playerMenu->addItem( MenuItem::create("Contact" , "LINK" , "contact") );
	$playerMenu->addItem( MenuItem::create("Info" , "LINK" , "info") );


	/*
		Examiner Menu
	 */
	$examinerMenu = Menu::create("ExaminerMenu");
	//Home
	$examinerMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );
 	//Questionnaires
	$examinerMenu->addItem( MenuItem::create("Questionnaires" , "LINK" , "questionnaireslist") );

	//Control panel
	$examinerControlPanelDropdown = MenuItem::create("Control Panel" , "DROPDOWN" , "");
	$examinerControlPanelDropdown->addItem( MenuItem::create("Create Questionnaire" , "LINK" , "questionnaire-create") );
	$examinerMenu->addItem($examinerControlPanelDropdown);
	//Requests
	$examinerRequestsDropdown = MenuItem::create("Requests" , "DROPDOWN" , "");
	$examinerRequestsDropdown->addItem(MenuItem::create("Participation requests" , "LINK" , "participation-requests"));
	$examinerMenu->addItem($examinerRequestsDropdown);
	//Contact
	$examinerMenu->addItem( MenuItem::create("Contact" , "LINK" , "contact") );
	//Info
	$examinerMenu->addItem( MenuItem::create("Info" , "LINK" , "info") );


	/*
		Moderator Menu
	 */
	$moderatorMenu = Menu::create("ModeratorMenu");
	//Home
	$moderatorMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );
	//Questionnaires
	$moderatorMenu->addItem(MenuItem::create("Questionnaires" , "LINK" , "questionnaireslist"));
	//Control panel
	$moderatorControlPanelDropdown = MenuItem::create("Control Panel" , "DROPDOWN" , "");
	$moderatorControlPanelDropdown->addItem( MenuItem::create("Create Questionnaire" , "LINK" , "questionnaire-create") );
	$moderatorControlPanelDropdown->addItem( MenuItem::create("Manage Questionnaires" , "LINK" , "questionnaire-management") );
	$moderatorMenu->addItem( $moderatorControlPanelDropdown );
	//Requests
	$moderatorRequestsDropdown = MenuItem::create("Requests" , "DROPDOWN" , "");
	$moderatorRequestsDropdown->addItem( MenuItem::create("Participation requests" , "LINK" , "participation-requests") );
	$moderatorRequestsDropdown->addItem( MenuItem::create("Publication requests" , "LINK" , "publication-requests") );
	$moderatorRequestsDropdown->addItem( MenuItem::create("Examiner applications" , "LINK" , "examiner-applications") );
	$moderatorMenu->addItem( $moderatorRequestsDropdown );
	//Info
	$moderatorMenu->addItem( MenuItem::create("Info" , "LINK" , "info") );

	/*
		Right menu that will show when a user has not logged in.
	 */
	$unauthorizedRightMenu = Menu::create("UnauthorizedRightMenu");

	$unauthorizedRightMenu->addItem( MenuItem::create("Log In" , "MODAL" , "#loginModal") );
	$unauthorizedRightMenu->addItem( MenuItem::create("Register" , "MODAL" , "#registerModal") );


	/*
		Right menu that will show when a user has logged in
	 */
	$authorizedRightMenu = Menu::create("authorizedRightMenu");

	//My menu
	$myRightDropdown = MenuItem::create("<i style='font-size:18px;color:#36A0FF' class='glyphicon glyphicon-user'></i> " , "DROPDOWN" , "");
	$myRightDropdown->addItem( MenuItem::create("My Profile" , "LINK" , "profile") );
	$myRightDropdown->addItem( MenuItem::create("My Questionnaires" , "LINK" , "my-questionnaires") );
	$authorizedRightMenu->addItem( $myRightDropdown );

	$authorizedRightMenu->addItem( MenuItem::create("Sign Out" , "LINK" , "signout") );

	Menus::add($examinerMenu);
	Menus::add($moderatorMenu);
	Menus::add($playerMenu);
	Menus::add($guestMenu);
	Menus::add($unauthorizedRightMenu);
	Menus::add($authorizedRightMenu);
