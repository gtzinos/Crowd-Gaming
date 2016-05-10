<?php
    
    require '../core/database/Database.php';
    require '../core/Controller.php';
    require '../core/util/Utils.php';
    require '../core/router/RouteDispatcher.php';
    require '../core/router/Routes.php';

    /*
        start session
        Normaly this shouldnt exist
        rest apis have no session
    */
    session_start();    

	/*
		User level constants
	*/
	$_USER_LEVEL["MODERATOR"] = 3;
	$_USER_LEVEL["EXAMINER"] = 2;
	$_USER_LEVEL["PLAYER"] = 1;
	$_USER_LEVEL["GUEST"] = 0;


	include '../app/config/config_general.php';
	include '../app/config/config_api_routes.php';


    $routeDispatcher = new RouteDispatcher();

    if( isset( $_GET["path"] ) ){
        $route = $routeDispatcher->dispatchWithRegex($_GET["path"]);
    }else{
        $route = $routeDispatcher->dispatchWithRegex($_CONFIG["DEFAULT_ROUTE"]);
    }

    /*
        Include the file and create the controller object
    */
    include '../app/controller/'.$route["controller"];

    $controllerName = basename($route["controller"] , ".php" );
    $controller = new $controllerName($route["parameters"]);