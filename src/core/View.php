<?php
    /**
     *  This file contains the View class.
     *  this class holds the main view file
     *  that must be included and the css
     *  files that is uses
     */
    class View{
        /*
            The path to the view file
        */
        private $path;
        /*
            This is an array holding the names
            of the css files that the view file
            neeeds
        */
        private $css;
        public function setPath($path){
            $this->path = $path;
        }

        public function addCss($name){
            $this->css[] = $name;
        }

        public function project($args){
            include '../src/views/'.$this->path;
        }

        public function linkCss(){
            for( $i = 0 ; $i < count($this->css) ; $i++){
                print '<link rel="stylesheet" href="../src/views/css/'.$this->css[$i].'" >';
            }
        }
    }
