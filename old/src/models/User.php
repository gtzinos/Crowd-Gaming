<?php
  /*
    This file contains an abstact class that describes a User
  */
   try
   {
    if(!@include_once("../src/core/Database.php")) {
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


  abstract class User {
    /*
      User information
    */
    protected $id;
    protected $email;
    protected $name;
    protected $surname;
    protected $country;
    protected $city;
    protected $address;
    protected $phone;
    protected $last_login;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function setSurname($surname){
        $this->surname = $surname;
    }

    public function getGender(){
        return $this->gender;
    }

    public function setGender($gender){
        $this->gender = $gender;
    }

    public function getCountry(){
        return $this->$country;
    }
    public function setCountry($country){
        $this->$country = $country;
    }

    public function getCity(){
        return $this->$city;
    }
    public function setCity($city){
        $this->$city = $city;
    }

    public function getAddress(){
        return $this->$address;
    }
    public function setAddress($address){
        $this->$address = $address;
    }

    public function getPhone(){
        return $this->$phone;
    }
    public function setPhone($phone){
        $this->$phone = $phone;
    }

    public function getLastLogin(){
        return $this->last_login;
    }
    public function setLastLogin($last_login){
        $this->$last_login = $last_login;
    }

    /*
        Creates a user based on the id
    */
    public function create($id){
        $dbConnection = new DatabaseConnection();

        $dbQuery = new DatabaseQuery('select * from user where id=?' , $dbConnection);

        $dbQuery->addParameter('i',$id);
        $set = $dbQuery->execute();

        if($set->getRowCount() <= 0)
            return false;

        $row = $set->next();
        $this->id = $id;
        $this->email = $row["email"];
        $this->name = $row["name"];
        $this->surname = $row["surname"];
        $this->gender = $row["gender"];
        $this->country = $row["country"];
        $this->city = $row["city"];
        $this->address = $row["address"];
        $this->phone = $row["phone"];
        $this->last_login = $row["last_login"];

        $dbConnection->close();
        return true;
    }

    /*
        returns true if the login was successful
        else it returns false
    */
    public function signIn($email,$password){
        $con = new DatabaseConnection();
        $query = new DatabaseQuery("select password,id from user where email=?" , $con);
        $query->addParameter('s',$email);
        $set = $query->execute();
        $user = $set->next();
        if(isset($user)){
            if(password_verify($password,$user["password"])){
                session_start();
                $_SESSION["uid"]=$user["id"];
                return TRUE;
            }
        }
        return FALSE;
    }

    /*
        create a user and insert his data in the database
    */
    public function signUp($username,$password,$email){
        $con = new DatabaseConnection();

        /*check if a user with the given username already exists*/
        $query = new DatabaseQuery("select id from user where email=?" , $con);
        $query->addParameter('s',$username);

        $set = $query->execute();
        if($set->getRowCount() > 0){
            /*if email is taken ,return false*/
            return FALSE;
        }


        /*create the sql query and add the parameters,id must be auto-increment*/
        $query = new DatabaseQuery("insert into user(email,password,access,name,surname,gender,country,city,address,phone,last_login) values(?,?,?,?,?,?,?,?,?,?,now())" , $con);


        $hashed_password = password_hash($password , PASSWORD_DEFAULT);
        $access = User::findUserAccessLevel('User');

        $query->addParameter("ssississsi",
            $email,
            $hashed_password,
            $access,
            $name,
            $surname,
            $gender,
            $country,
            $city,
            $address,
            $phone
        );



        $query->executeUpdate();


        /*
            return TRUE ,which means everything went well,maybe check the affected rows and
            return true only if effectedRows>0.

            If it returns true ,a call to login  should be made for the user to automatically login
        */
        return TRUE;
    }


  /*
      Get all the data of the user,the user must be logged in,'
      this is in the user class instread of the simpleUser cause both Admin and SimpleUser
      should have it,but in general this class should only have methods that an unregistered
      or unlogged user has to call
  */
  public function getData(){
      if(!isset($id)){
          /*id the user is not logged in,return null*/
          return NULL;
      }
      $con = new DatabaseConnection();
      $query = new DatabaseQuery("select * from user where id=?" , $con);
      $query->addParameter('i',$id);
      $row = $query->execute();

      // store user info
      $this->id = $id;
      $this->email = $row["email"];
      $this->name = $row["name"];
      $this->surname = $row["surname"];
      $this->gender = $row["gender"];
      $this->country = $row["country"];
      $this->city = $row["city"];
      $this->address = $row["address"];
      $this->phone = $row["phone"];
      $this->last_login = $row["last_login"];
  }

  /*
    signout method()
  */
  public function signOut(){
    session_destroy();
    return TRUE;
  }

  /**
   *  This method finds the id of a specific user type in the database.
   *  @param $user_type_string the user type we want the id
   *  @return an integer value of the id of the user type
   */
  public static function findUserAccessLevel($access_level_string){
      $con = new DatabaseConnection();

      $cmd = new DatabaseQuery("select id from AccessLevel where name=?" , $con);
      $cmd->addParameter('s',$access_level_string);
      $set = $cmd->execute();
      $row = $set->next();
      return $row['id'];
  }

  /*
      Checks if THIS user is logged in
  */
  public function checkIfLoggedIn(){
      if(isset($_SESSION["uid"])  && $_SESSION["uid"]==$this->id)
          return true;
      else
          return false;
  }

  /*
    Different functionallity for each of our users.
  */
  public abstract function questionairesList();

  /*
    Send email to us.
  */
  public function sendEmail($from,$header,$message) {

  }

}
 ?>
