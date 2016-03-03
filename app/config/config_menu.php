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
	$examinerMenu->addItem( MenuItem::create("Questionnaires" , "LINK" , "questionnaireslist") );
	$examinerMenu->addItem( MenuItem::create("Create Questionnaire" , "LINK" , "create-questionnaire") );
	$examinerMenu->addItem( MenuItem::create("Contact" , "LINK" , "contact") );



	/*
		Moderator Menu
	 */
	$moderatorMenu = Menu::create("ModeratorMenu");
	//Add menu items here

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
