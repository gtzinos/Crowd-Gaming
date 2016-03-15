<?php

	include '../core/ApiLauncher.php';

	/*
		This will give control to the controller.
		Dont remove this.
	 */
	$controller->setHeadless(true);
    $controller->handle();