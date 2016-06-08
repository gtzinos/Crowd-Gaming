<?php

	// global object
	$view = null;

	class HtmlView extends View
	{
		protected $sections;
		protected $template;
		protected $args;

		public function __construct()
		{
            $this->args = array();

			global $view;
			$view = $this;
		}

		public function display($output)
		{
			global $_CONFIG;
            $this->args = array_merge($this->args,$output);
            include '../app/templates/'.$this->template;
		}


		public function getViewOutput( $viewFile , $section)
        {
            ob_start();
            include '../app/view/'.$viewFile;

            return ob_get_clean();;
        }

        public function defSection($section , $viewFile)
        {
            $this->sections[$section] = $viewFile;
        }

        public function getSectionFile($section)
        {
            if(isset($this->sections[$section]))
                return $this->sections[$section];
            else
                return "Empty";
        }

        public function getTemplate()
        {
            return $this->template;
        }

        public function setTemplate($template)
        {
            $this->template = $template;
        }

        public function setArg($key , $value)
        {
            $this->args[$key] = $value;
        }

        public function getArg($key)
        {
            if(isset($this->args[$key]))
                return $this->args[$key];
            else
                return "";
        }

        public function exists($variable)
        {
            return array_key_exists($variable, $this->args);
        }
	}


    /*
        Loads a certain section
    */
    function load($section)
    {
        global $view;
        if(strcmp($view->getSectionFile($section) , "Empty") == 0)
        {
            return;
        }
        include '../app/view/'.$view->getSectionFile($section);
    }

    /*
        Print a variable
    */
    function show($variable)
    {
        global $view;
        print $view->getArg($variable);
    }

    /*
        Check if a variable exists
    */
    function exists($variable)
    {
        global $view;
        return $view->exists($variable);
    }

    /*
        Return a variable
    */
    function get($variable)
    {
        global $view;
        return $view->getArg($variable);
    }

    function set($key , $variable)
    {
        global $view;
        $view->setArg($key , $variable);
    }

    /*
        Return the text parsed using the parsedown library
    */
    function parse($text)
    {
        $parsedown = new Parsedown();
        return $parsedown->text($text);
    }
