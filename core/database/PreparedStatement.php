<?php

	class PreparedStatement{
		/*
			holds the query string
        */
        private $query;
        /*
			Holds the mysqli connection object
        */
        private $connection;

        /*
			Create the Prepared stetement
        */
		public function __construct($query,$connection){
            $this->query = $connection->prepare($query);
            $this->connection = $connection;
        }


        /*
            bind a parameter to the query ,char for a parameters in the original query should be ?
            example : select * from table where a=?
            and then addParameter('s','name');
            's' stands for string
        */
        public function setParameters($param_types){
            /*
                Get the parameters
            */
            $args = array_slice(func_get_args(),1);

            $params = array();

            $params[] = & $param_types;

            for($i=0 ; $i<count($args) ;$i++)
                $params[] = & $args[$i];


            call_user_func_array(array($this->query, 'bind_param'), $params);
        }


        /*
            Execute the query
            returns a ResultSet object
        */
        public function execute(){
            $this->query->execute();
            global $_CONFIG;
            /*
				Error Handling
            */
            if (mysqli_error($this->connection)){
            	if($_CONFIG["DEBUG"]){	
            		die(mysqli_error($this->connection));
	            }else{
	            	die("Database Query Error");
	            }
	        }

            $result = $this->query->get_result();
            $resultSet = new ResultSet($result);
            return $resultSet;
        }



        public function executeUpdate(){
            $this->query->execute() ;

            global $_CONFIG;
            /*
				Error Handling
            */
        	if (mysqli_error($this->connection)){
            	if($_CONFIG["DEBUG"]){	
            		die(mysqli_error($this->connection));
	            }else{
	            	die("Database Query Error");
	            }
	        }
        }

       	public function executeScalar(){
       		//not implemented
       	}
	}