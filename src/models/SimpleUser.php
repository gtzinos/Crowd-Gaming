<?php
  /*
      This scripts contains the SimpleUser class
      It defines the basic action of a registered user
  */

  try
  {
   if(!@include_once("../src/models/User.php")) {
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

  class SimpleUser extends User {

    /*
    constructor used to create the object when the user is login in or creating a new account.
    After this,login or signup should be called to populate the object
    */
    function __construct(){

    }

    /*
      Visible non started Questionaires List
    */
    public function questionairesList()
    {
      
    }

    /*
      Can join to one visible
      and non started questionaire
    */
    public function requestJoinQuestionaire($questionaireId)
    {

    }
    /*
      Can find which questionaires have join
    */
    public function joinedQuestionaires($questionaireId)
    {

    }
    /*
      Can request for examiner privileges
    */
    public function requestExaminerPrivileges()
    {

    }





  }


?>
