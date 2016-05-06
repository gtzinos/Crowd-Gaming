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

	/*
		Examiner Menu
	 */
	$examinerMenu = Menu::create("ExaminerMenu");
	$examinerMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );

	$examinerQuestionnaires = MenuItem::create("Questionnaires" , "DROPDOWN" , "");
	$examinerQuestionnaires->addItem( MenuItem::create("Questionnaires list" , "LINK" , "questionnaireslist") );
	$examinerQuestionnaires->addItem( MenuItem::create("Create Questionnaire" , "LINK" , "questionnaire-create") );

	$examinerControlPanel = MenuItem::create("Control Panel" , "DROPDOWN" , "");
	$examinerControlPanel->addItem( MenuItem::create("Participation requests" , "LINK" , "participation-requests") );

  $examinerMenu->addItem($examinerQuestionnaires);
	$examinerMenu->addItem($examinerControlPanel);
	$examinerMenu->addItem( MenuItem::create("Contact" , "LINK" , "contact") );



	/*
		Moderator Menu
	 */
	$moderatorMenu = Menu::create("ModeratorMenu");

	$moderatorQuestionnaires = MenuItem::create("Questionnaires" , "DROPDOWN" , "");
	$moderatorQuestionnaires->addItem( MenuItem::create("Questionnaires list" , "LINK" , "questionnaireslist") );
	$moderatorQuestionnaires->addItem( MenuItem::create("Create Questionnaire" , "LINK" , "questionnaire-create") );

	$moderatorControlPanel = MenuItem::create("Control Panel" , "DROPDOWN" , "");
	$moderatorControlPanel->addItem( MenuItem::create("Manage Questionnaires" , "LINK" , "questionnaire-management") );
	$moderatorControlPanel->addItem( MenuItem::create("Participation requests" , "LINK" , "participation-requests") );
	$moderatorControlPanel->addItem( MenuItem::create("Publication requests" , "LINK" , "publication-requests") );

	$moderatorMenu->addItem( MenuItem::create("Home" , "LINK" , "home") );
	$moderatorMenu->addItem( $moderatorQuestionnaires );
	$moderatorMenu->addItem( $moderatorControlPanel );
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

	$authorizedRightMenu->addItem( MenuItem::create("Profile" , "LINK" , "profile") );
	$authorizedRightMenu->addItem( MenuItem::create("Sign Out" , "LINK" , "signout") );

	Menus::add($examinerMenu);
	Menus::add($moderatorMenu);
	Menus::add($playerMenu);
	Menus::add($guestMenu);
	Menus::add($unauthorizedRightMenu);
	Menus::add($authorizedRightMenu);
