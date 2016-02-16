<?php

	class Menu{

		private $name;
		private $menuItems;

		public function setName($name){
			$this->name = $name;
		}

		public function getName(){
			return $this->name;
		}

		public function addItem($menuItem){
			$this->menuItems[] = $menuItem;
		}

		public function getItems(){
			return $this->menuItems;
		}


		public static function create($name){
			$menu = new Menu();
			$menu->setName($name);

			return $menu;
		}
	}