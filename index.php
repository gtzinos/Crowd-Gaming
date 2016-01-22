<?php
    require 'system/Config.php';
    require 'system/database/Database.php';
    require 'system/Page.php';
    require 'system/Controller.php';
    require 'system/util/Utils.php';


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


    /*
        Create the page from the GET parameters if exists
        else get the default page
    */
    if( isset($_GET["p"] )){
        $page = Page::get($_GET["p"]);
    }else{
        $page = Page::get($_CONFIG["DEFAULT_PAGE"]);
    }

    $_SESSION["CURRENT_PAGE"] = $page->getCodename();

    /*
        Include the file and create the controller object
    */
    include "pages/".$page->getControllerPath();

    $controllerName = basename($page->getControllerPath() , ".php" );
    $controller = new $controllerName;


    /*
        Execute the controller methods
    */
    $controller->handle($page);


    /*
        Close the database connection if there is one
    */
    DatabaseConnection::dispose();