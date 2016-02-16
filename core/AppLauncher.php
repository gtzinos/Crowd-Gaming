<?php
    
    require '../core/database/Database.php';
    require '../core/Controller.php';
    require '../core/util/Utils.php';
    require '../core/router/RouteDispatcher.php';
    require '../core/router/Routes.php';
    require '../core/navigation/Menus.php';
    require '../core/Config.php';


    /*
        start session
    */
    session_start();    
    

    /*
        Check Session Timeout
    */
    if($_CONFIG["SESSION_TIMEOUT"] != "-1"){
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (int)$_CONFIG["SESSION_TIMEOUT"])){
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    }

    /*
        Init user level
    */
    if(!isset($_SESSION["USER_LEVEL"])){
        $_SESSION["USER_LEVEL"] = 0;
    }


    $routeDispatcher = new RouteDispatcher();

    if( isset( $_GET["path"] ) ){
        $route = $routeDispatcher->dispatch($_GET["path"]);
    }else{
        $route = $routeDispatcher->dispatch($_CONFIG["DEFAULT_ROUTE"]);
    }

    /*
        Include the file and create the controller object
    */
    include '../app/controller/'.$route["controller"];

    $controllerName = basename($route["controller"] , ".php" );
    $controller = new $controllerName($route["parameters"]);
