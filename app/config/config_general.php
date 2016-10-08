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
	$_CONFIG["WEB_ROOT"] = "./Crowd-Gaming/public/";
	/*
		Short application name
	*/
	$_CONFIG["SHORT-APP-NAME"] = "Crowd Game" ;
	/*
		Full application name
	*/
	$_CONFIG["FULL-APP-NAME"] = "Crowd Gaming" ;
	/*
		Default timezone
	 */
	$_CONFIG["SERVER_TIMEZONE"] = "Europe/Athens";
	/*
		Version number
	*/
	$_CONFIG["VERSION"] = "0";
	/*
		Google api key , web client needs it
	 */
	$_CONFIG["GOOGLE_ANALYTICS_ID"] = "UA-82084036-1";
	/*
		Google api key , web client needs it
	 */
	$_CONFIG["GOOGLE_API_KEY"] = "AIzaSyCclvgjNy2vp9rD8TrAnbNs4wvXft7hKiY";
	/*
		Google recaptcha key , web client needs it
	*/
	$_CONFIG["CLIENT_GOOGLE_RECAPTCHA_KEY"] = "6LeluyETAAAAADhNCPmzGYok8f1jfKYgRr36T33A";
	/*
		Google recaptcha key , web client needs it
	*/
	$_CONFIG["SERVER_GOOGLE_RECAPTCHA_KEY"] = "6LeluyETAAAAAGkhURxe-cskHtd2yWSwyeUsxr1P";
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
	/*
		This will be the email address that the system will
		send the messages from the Contact page
	 */
	$_CONFIG["CONTACT_EMAIL"] = "geotzinos@gmail.com";
	/*
		Specify main and backup SMTP *For contact forms
	 */
	$_CONFIG["SMTP_HOST"] = "smtp.gmail.com";
	/*
		SMTP username *For contact forms
	 */
	$_CONFIG["SMTP_USERNAME"] = "";
	/*
		SMTP password, DONT COMMIT YOUR PASSWORD TO GITHUB! *For contact forms
	 */
	$_CONFIG["SMTP_PASSWORD"] = "";
	/*
		TCP port to connect to *For contact forms
	 */
	$_CONFIG["SMTP_PORT"] = 587;
	/*
		Enable TLS encryption, `ssl` also accepted *For contact forms
	 */
	$_CONFIG["SMTP_SECURE"] = "tls";
