<?php

	class PreparedStatement{
		/*
			holds the query object
        */
        private $query;
        /*
            Holds the query string
         */
        private $queryString;
        /*
			Holds the mysqli connection object
        */
        private $connection;

        /*
			Create the Prepared stetement
        */
		public function __construct($query,$connection){
            $this->queryString = $query;
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

            try{
                call_user_func_array(array($this->query, 'bind_param'), $params);
            }
            catch(Exception $e){
                throw new DatabaseException("Error while trying to bind the parameters of query ".$this->queryString);
            }
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
            	throw new DatabaseException("Error when trying to execute query ".$this->queryString);
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
            	throw new DatabaseException("Error when trying to execute update query ".$this->queryString);
	        }
        }

       	public function executeScalar(){
       		//not implemented
       	}
	}