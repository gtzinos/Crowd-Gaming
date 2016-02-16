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
		Right menu that will show when a user has not logged in.
	 */
	$unauthorizedRightMenu = Menu::create("UnauthorizedRightMenu");

	$unauthorizedRightMenu->addItem( MenuItem::create("Sign In" , "MODAL" , "#loginModal") );
	$unauthorizedRightMenu->addItem( MenuItem::create("Sign Up" , "MODAL" , "#registerModal") );


	/*
		Right menu that will show when a user has logged in
	 */
	$authorizedRightMenu = Menu::create("authorizedRightMenu");

	$authorizedRightMenu->addItem( MenuItem::create("Profile" , "LINK" , "profile") );
	$authorizedRightMenu->addItem( MenuItem::create("Sign Out" , "LINK" , "signout") );



	Menus::add($guestMenu);
	Menus::add($unauthorizedRightMenu);
	Menus::add($authorizedRightMenu);