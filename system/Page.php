<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	class Page {

		protected $name;
		protected $codename;
		protected $controllerPath;
		protected $userLevel;

		/*****
			Get and Set Methods bellow
		*****/
		/*
			Gets the name
			@return the name
		*/
		public function getName(){
			return $this->name;
		}

		/*
			Sets the name
			@param $name the name to set
		*/
		public function setName($name){
			$this->name=$name;
		}

		/*
			Gets the codename
			@return the codename
		*/
		public function getCodename(){
			return $this->codename;
		}

		/*
			Sets the codename
			@param $codename the codename to set
		*/
		public function setCodename($codename){
			$this->codename=$codename;
		}


		/*
			Gets the controllerPath
			@return the controllerPath
		*/
		public function getControllerPath(){
			return $this->controllerPath;
		}

		/*
			Sets the controllerPath
			@param $controllerPath the controllerPath to set
		*/
		public function setControllerPath($controllerPath){
			$this->controllerPath=$controllerPath;
		}

		public function getUserLevel(){
			return $this->userLevel;
		}

		public function setUserLevel($userLevel){
			$this->userLevel = $userLevel;
		}


		public static function get($codename){
			global $_PAGES;


			if(array_key_exists($codename, $_PAGES) && $_SESSION["USER_LEVEL"] >= $_PAGES[$codename]["userLevel"] ){
				$page = new Page();
				
				$page->setName($_PAGES[$codename]["name"]);
				$page->setCodename($codename);
				$page->setControllerPath($_PAGES[$codename]["controllerPath"]);
				$page->setUserLevel($_PAGES[$codename]["userLevel"]);
			}else{
				global $_CONFIG;
				
				

				http_response_code(404);
				$page = self::get($_CONFIG["404_PAGE"]);

			}

			return $page;

		}
	}