<?php
    
    require 'AppCore.php';    
    require '../app/config/config_routes.php';

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
