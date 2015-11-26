<?php
    include_once '../src/core/View.php';
    /*
        Controller class, all controllers must extend this class
        right now it only forces you to implement the handle method
        it might do other operations in the future.
    */
    abstract class Controller{
        protected $title = "Treasure-Thess";
        private $view ;

        public function getTitle(){
            return $this->title;
        }
        public function setTitle($title){
            $this->title = $title;
        }

        abstract public function handle();

        protected function setView($view_file){
            $this->view = new View();
            $this->view->setPath($view_file);
        }
        protected function addCss($name){
            $this->view->addCss($name);
        }

        protected function showView($args = null){
          if(isset($this->view))$this->view->project($args);
        }

        public function linkCss(){
            if(isset($this->view))$this->view->linkCss();
        }
    }
