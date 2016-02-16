<?php

	/*
		User level constants
	*/
	$_USER_LEVEL["MODERATOR"] = 10;
	$_USER_LEVEL["EXAMINER"] = 7;
	$_USER_LEVEL["PLAYER"] = 4;
	$_USER_LEVEL["GUEST"] = 0;


	//Init the array that will hold all the information about the menus	
	$_MENUS = array();


	function menu_add_item($menu_name , $page_codename , $order , $label){
		global $_MENUS;

		$_MENUS[$menu_name][$order]["page"] = $page_codename;
		$_MENUS[$menu_name][$order]["label"] = $label;
	}

	include '../app/config/config_general.php';
	include '../app/config/config_routes.php';
	include '../app/config/config_menu.php';