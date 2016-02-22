<?php
	/*
		True if debuging is on else false
		disable this before release
	*/
	$_CONFIG["DEBUG"] = "true" ;
	/*
		The application path relative to the web root. It should point to the public folder.
		Leave empty if the public folder IS the root.
		WEB_ROOT Must end with '/' if exists.
	 */
	$_CONFIG["WEB_ROOT"] = "Treasure-Thess-Website/public/";
	/*
		Version number
	*/
	$_CONFIG["VERSION"] = "0";
	/*
		Version String
	*/
	$_CONFIG["VERSION_STRING"] = "0.X Development Version";
	/*
		Main Tempate
	*/
	$_CONFIG["BASE_TEMPLATE"] = "main/main.php";
	/*
		Enable/Disable Cache mechanism
		*Not Implemented*
	*/
	$_CONFIG["CACHE"] = "false";
	/*
		Database Username
	*/
	$_CONFIG["DB_USERNAME"] = "root";
	/*
		Database Password
	*/
	$_CONFIG["DB_PASSWORD"] = "";
	/*
		Database Address
	*/
	$_CONFIG["DB_ADDRESS"] = "localhost";
	/*
		Database Schema
	*/
	$_CONFIG["DB_SCHEMA"] = "quizapp";
	/*
		Session Timeout in minutes, -1 means disabled
	*/
	$_CONFIG["SESSION_TIMEOUT"] = "1800";
