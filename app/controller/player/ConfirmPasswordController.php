<?php
    include_once '../app/model/domain/user/User.php';
    include_once '../app/model/mappers/user/UserMapper.php';

    class ConfirmPasswordController extends Controller
    {

        public function init()
        {
            $this->setHeadless(true);
        }

        public function run()
        {
            /*
                If everything ok with sended values
            */
            if( isset($_SESSION["USER_ID"]) && isset($_POST["password"]) )
            {
                /*
                    Initialize variables
                */
                $password = $_POST["password"];
                /*
                  Check for wright parameters
                  or return error codes
                */

                /*
                  If password was wrong then
                  print error_code = 1
                */
                if( strlen($password) < 8 )
                {
                    print '1';
                    die();
                }
                else
                {
                    $password = password_hash($password , PASSWORD_DEFAULT);
                }


                $userMapper = new UserMapper();
                /*
                  Create a user from user id
                  cause email can change
                */
                $databaseInfo = $userMapper->findById($_SESSION["USER_ID"]);
                /*
                  If value returned
                */
                if($databaseInfo)
                {
                    /*
                        Try to authenticate and
                        Create a client User Object
                        OR
                        Compare
                        if (strcmp($_POST["password"],$databaseInfo->getPassword()) == 0)
                    */

                    $user = $userMapper->authenticate($databaseInfo->getEmail(),$_POST["password"]);

                    /*
                        If was an object like User
                    */
                    if( is_object($user))
                    {
                        $user->login();
                        print '0';
                    }
                      /*
                        Wrong old password
                      */
                    else
                    {
                        print '2';
                    }
                }  
                else
                {
                    $this->redirect("home");
                }
            }
        }
    }
