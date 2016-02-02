<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	/*
		Menus
	 
		menu_add_item( Name of Menu , The codename of the page , Order , Label );

	 */

	menu_add_item("Guest" , "home" , 0 , "Home");

	menu_add_item("unauthorized" , "signin" , 0 , "Sign In");
	menu_add_item("unauthorized" , "signup" , 1 , "Sign Up");

	menu_add_item("authorized" , "profile" , 0 , "My Profile");
	menu_add_item("authorized" , "signout" , 1 , "Sign Out");


	/*
		The primary menu for the front side website
	*/
	$_CONFIG["PRIMARY_MENU"] = "Guest";
	/*
		The menu that will show on the right of the nav bar.
	 */
	$_CONFIG["SECONDARY_MENU"] = "unauthorized";