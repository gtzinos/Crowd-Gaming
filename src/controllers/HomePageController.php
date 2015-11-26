<?php
    include_once '../src/models/Question.php';
    /*
     *  This file contains the controller for the main page
     *  this page show the latest/top etc questionaires
     */
     class HomePageController extends Controller {

        public function __construct() {
          /*
              set the title of the page
          */
          $this->setTitle("Home Page");

          /*
              Set the view file
          */
          $this->setView("index.html");
          /*
              Add the css files
          */
          $this->addCss("home.css");
        }

        /*
          We must display all visible and
          no started questionaires
        */
        public function handle() {

        }



     }




?>
