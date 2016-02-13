<?php
    /*
        This scripts should run only if it is included by the application.
     */
    global $_IN_SAME_APP ;
    if(!isset($_IN_SAME_APP)){die("Not authorized access");}


    require_once 'system/ext/Parsedown.php';


    $controller = null;
    /*
        Controller class, all controllers must extend this class
        right now it only forces you to implement the handle method
        it might do other operations in the future.
    */
    abstract class Controller{

        protected $page;
        private $args;
        private $sections;
        private $headless;
        private $template;

        public function __construct(){
            global $controller;

            $this->headless = false;
            $controller = $this;
        }

        abstract public function init();
        abstract public function run();


        public function handle($page){
            $this->page = $page;

            $this->setArg("PAGE_TITLE", $this->page->getName());


            $this->init();
            $this->run();


            if( !$this->isHeadless() ){
                global $_CONFIG;
                include 'templates/'.$this->template;
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

        public function getTemplate(){
            return $this->template;
        }

        public function setTemplate($template){
            $this->template = $template;
        }

        public function exists($variable){
            return isset($this->args[$variable]);
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

        public function redirect($page){
            header("Location: ".Utils::generatePageLink($page));
            die();
        }

        public function redirectGetPars($page,$name,$value){
            header("location: ".Utils::genPageLinkWithParameters($page,$name,$value));
            die();
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
        include $controller->getSectionFile($section);
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
