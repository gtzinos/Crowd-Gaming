<?php

    /*
        User level constants
    */
    $_USER_LEVEL["MODERATOR"] = 3;
    $_USER_LEVEL["EXAMINER"] = 2;
    $_USER_LEVEL["PLAYER"] = 1;
    $_USER_LEVEL["GUEST"] = 0;

    require '../core/database/Database.php';
    require '../core/Controller.php';
    require '../core/view/View.php';
    require '../core/view/HtmlView.php';
    require '../core/view/JsonView.php';
    require '../core/view/CodeView.php';
    require '../core/util/Utils.php';
    require '../core/router/RouteDispatcher.php';
    require '../core/router/Routes.php';
    require '../core/navigation/Menus.php';
    require '../core/validation/Validator.php';

    require '../app/config/config_general.php';
    require '../app/config/config_menu.php';
    require '../app/config/config_validations.php';


    /*
        start session
    */
    session_start();   


    /*
        Check Session Timeout
    */
    if($_CONFIG["SESSION_TIMEOUT"] != "-1")
    {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (int)$_CONFIG["SESSION_TIMEOUT"]))
        {
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    }

    /*
        Init user level
    */
    if(!isset($_SESSION["USER_LEVEL"]))
    {
        $_SESSION["USER_LEVEL"] = 0;
    }