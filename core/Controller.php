<?php

    require_once '../libs/Parsedown.php';


    abstract class Controller
    {
        protected $output;
        protected $headless;
        protected $view;
        protected $params;
        protected $validator;

        public function __construct($params)
        {
            $this->params = $params;
            $this->output = array();
            $this->setHeadless( false );
            $this->init();
        }

        abstract public function init();
        abstract public function run();

        public function handle()
        {
            $this->run();

            if( !$this->isHeadless() )
            {
                $this->view->display($this->output); 
            }
        }

        public function getValidator(){
            return $this->validator;
        }
        
        public function setValidator($validator){
            $this->validator = $validator;
        }

        public function getView(){
            return $this->view;
        }
        
        public function setView($view){
            $this->view = $view;
        }

        public function setOutput($key , $value )
        {
            $this->output[$key] = $value;
        }

        public function getOutput($key)
        {
            return $this->output[$key];
        }

        public function isHeadless()
        {
            return $this->headless;
        }

        public function setHeadless($headless)
        {
            $this->headless = $headless;
        }

        public function redirect($uri)
        {
            header("Location: ".LinkUtils::generatePageLink($uri));
            die();
        }
    }
