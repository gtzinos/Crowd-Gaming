<?php
    /*
        This file contains 3 classes DatabaseConnection
        and DatabaseQuery and ResultSet. The first is used  to open a
        connection to the database   and  the second to
        create  and  run a query  on  an  already  open
        database   connection   DatabaseQuery  is  safe
        against  sql injections because it uses prepared
        statements

    */

    class DatabaseConnection{
        // Variable that holds the connection
        private $mysql;

        /*
            Create the database connection
            if no parameters are passed we create it
            with the default ones.
            $socket and $port will most likely not be used.

        */
        public function __construct($hostname = "localhost" ,$user = "x" ,$pass = "x",$database = "x",$socket = "null",$port = "null"){
            if($port!="null" && $socket!="null"){
                // create db from unix domain socket
            }else{
                $this->mysql = new mysqli($hostname,$user,$pass,$database);
            }
        }

        /*
            returns the mysql connection
        */
        public function getConnection(){
            return $this->mysql;
        }

        /*
            Close database connection
        */
        public function close(){
            $this->mysql->close();
        }

    }

    class DatabaseQuery{
        // holds the prepared query
        private $query;
        private $connection;

        // constructor
        public function __construct($query,$connection){
            // create the prepared query
            $this->query = $connection->getConnection()->prepare($query);
            $this->connection = $connection;
        }

        /*
            bind a parameter to the query ,char for a parameters in the original query should be ?
            example : select * from table where a=?
            and then addParameter('s','name');
            's' stands for string
         */
        public function addParameter($param_types){
            /*
                Get the parameters.
            */

            /*
                returns the sequence of elements from the array array as specified
                by the offset and length parameters.
            */
            $args = array_slice(func_get_args(),1);

            $params = array();

            $params[] = & $param_types;

            for($i=0 ; $i<count($args) ;$i++)
                $params[] = & $args[$i];


            call_user_func_array(array($this->query, 'bind_param'), $params);
        }
        /*
          returns the query
        */
        public function getQuery(){
          return $this->query;
        }

        /*
            Execute the query
            returns a ResultSet object
        */
        public function execute(){
            $this->query->execute() or die(mysqli_error($this->connection->getConnection()));
            $result = $this->query->get_result();
            $resultSet = new ResultSet($result);
            return $resultSet;
        }



        public function executeUpdate(){
            $this->query->execute();
        }

    }


    class ResultSet{
        private $result;

        public function __construct($result){
            $this->result = $result;
        }

        public function next(){
            return $this->result->fetch_assoc();
        }
        public function getRawResult(){
          return $this->result;
        }
        public function getRowCount(){
            return $this->result->num_rows;
        }
    }
