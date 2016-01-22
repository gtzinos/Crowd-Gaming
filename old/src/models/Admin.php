<?php
    /*
        This scripts contains the Administrator class
        It defines the action of an administrator user
    */
    try
    {
     if(!@include_once('../src/models/User.php')) {
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



    class Admin extends User{

        /*
          constructor used to create the object when the user is login in or creating a new account.
          After this,login or signup should be called to populate the object
        */
        function __construct(){

        }

        public function banAccount($user_id){

        }

        public function deleteQuestion($question_id){

        }

        public function deleteComment($comment_id){

        }

    }
