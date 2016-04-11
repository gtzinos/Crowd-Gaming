<?php

    require_once '../libs/Parsedown.php';

    abstract class OutputType{
        const NormalView = 0;
        const XmlView = 1;
        const JsonView = 2;
        const ResponseStatus = 3;
    }

    $controller = null;
    /*
        Controller class, all controllers must extend this class
        right now it only forces you to implement the handle method
        it might do other operations in the future.
    */
    abstract class Controller{

        private $output;
        private $args;
        private $sections;
        private $headless;
        private $template;
        private $outputType;

        protected $params;

        public function __construct($params){
            $this->params = $params;

            global $controller;

            $this->setHeadless( false );
            $this->setOutputType( OutputType::NormalView );

            $controller = $this;
        }

        abstract public function init();
        abstract public function run();


        public function handle(){

            $this->init();
            $this->run();


            if( !$this->isHeadless() ){

                switch ( $this->getOutputType() ) {
                    case OutputType::XmlView :
                        // Not implemented.
                        break;
                    case OutputType::NormalView :
                        global $_CONFIG;
                        include '../app/templates/'.$this->template;
                        break;
                    case OutputType::JsonView :
                        header('Content-Type: application/json');
                        print json_encode($this->output);
                        break;
                    case OutputType::ResponseStatus :
                        print $this->getOutput("response-code");
                        break;
                }   
            }

        }

        public function setArg($key , $value){
            $this->args[$key] = $value;
        }

        public function getArg($key){
            if(isset($this->args[$key]))
                return $this->args[$key];
            else
                return "";
        }

        public function setOutput($key , $value ){
            $this->output[$key] = $value;
        }

        public function getOutput($key){
            return $this->output[$key];
        }

        public function getTemplate(){
            return $this->template;
        }

        public function setTemplate($template){
            $this->template = $template;
        }

        public function exists($variable){
            return array_key_exists($variable, $this->args);
        }

        public function defSection($section , $viewFile){
            $this->sections[$section] = $viewFile;
        }

        public function getSectionFile($section){
            if(isset($this->sections[$section]))
                return $this->sections[$section];
            else
                return "Empty";
        }

        public function isHeadless(){
            return $this->headless;
        }

        public function setHeadless($headless){
            $this->headless = $headless;
        }

        public function setOutputType($outputType){
            $this->outputType = $outputType;
        }

        public function getOutputType(){
            return $this->outputType;
        }

        public function redirect($uri){
            header("Location: ".LinkUtils::generatePageLink($uri));
            die();
        }

        public function getViewOutput( $viewFile , $section){
            ob_start();
            include '../app/view/'.$viewFile;

            return ob_get_clean();;
        }

    }


    /*
        Global Helper functions for use in the view and template files
    */


    /*
        Loads a certain section
    */
    function load($section){
        global $controller;
        if(strcmp($controller->getSectionFile($section) , "Empty") == 0){
            return;
        }
        include '../app/view/'.$controller->getSectionFile($section);
    }

    /*
        Print a variable
    */
    function show($variable){
        global $controller;
        print $controller->getArg($variable);
    }

    /*
        Check if a variable exists
    */
    function exists($variable){
        global $controller;
        return $controller->exists($variable);
    }

    /*
        Return a variable
    */
    function get($variable){
        global $controller;
        return $controller->getArg($variable);
    }

    function set($key , $variable){
        global $controller;
        $controller->setArg($key , $variable);
    }

    /*
        Return the text parsed using the parsedown library
    */
    function parse($text){
        $parsedown = new Parsedown();
        return $parsedown->text($text);
    }
