<?php
	/*
		User level constants
	*/
	$_USER_LEVEL["MODERATOR"] = 10;
	$_USER_LEVEL["EXAMINER"] = 7;
	$_USER_LEVEL["PLAYER"] = 4;
	$_USER_LEVEL["GUEST"] = 0;


	//Init the array that will hold all the information about the pages
	$_PAGES = array();
	//Init the array that will hold all the information about the menus	
	$_MENUS = array();


	/*
		$labelText must be false if there is no labelText.

		The user level constants defined on this page must be used for $userLevel
	*/
	function define_page($name , $codename , $controllerPath , $userLevel){
		global $_PAGES;

		$_PAGES[$codename]["name"] = $name;

		if($controllerPath == false)
			$_PAGES[$codename]["controllerPath"] = "System/Default/PageController.php";
		else
			$_PAGES[$codename]["controllerPath"] = $controllerPath;
		$_PAGES[$codename]["userLevel"] = $userLevel;

	}

	function menu_add_item($menu_name , $page_codename , $order , $label){
		global $_MENUS;

		$_MENUS[$menu_name][$order]["page"] = $page_codename;
		$_MENUS[$menu_name][$order]["label"] = $label;
	}

	include 'system/conf/config_page.php';
	include 'system/conf/config_menu.php';
	include 'system/conf/config_general.php';