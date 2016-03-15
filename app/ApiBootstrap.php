<?php

	include '../core/ApiLauncher.php';


	header('Content-Type: application/json');
	$controller->setHeadless(true);
	/*
		This will give control to the controller.
		Dont remove this.
	 */
    $controller->handle();