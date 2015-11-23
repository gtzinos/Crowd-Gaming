<?php
  /*
    This file contains an abstact class that describes a User
  */
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


  }







 ?>
