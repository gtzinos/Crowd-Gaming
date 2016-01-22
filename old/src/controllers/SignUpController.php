<?php
    /*
      Controller for sign up requests
    */

    try
    {
     if(!@include_once("../src/models/SimpleUser.php")
          || !@include_once("../src/core/Controller.php")) {
       /*
         Someone try to do something illegal
       */
       throw new Exception ('100');
     }
    }
    catch(Exception $e)
    {
      header('Location: /');
    }

    class SignUpController extends Controller {
        public function __construct() {
          /*
              set the title of the page
          */
          $this->setTitle("Join us!");
          /*
              Set the view file
          */
          $this->setView("signup.php");

        }

        public function handle() {
          if(!empty($_POST)) {
            $error = FALSE;
          }
          $error_msg = "";
          if($_POST["username"]==""){
            $error_msg .= "Username can't be empty";
            $error=TRUE;
          }


        }


    }


?>
