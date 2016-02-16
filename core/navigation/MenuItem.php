<?php
	
	class MenuItem{

		private $label;

		private $type;

		private $subItems;

		private $action;

		public function setType($type){
			$this->type= $type;
		}

		public function getType(){
			return $this->type;
		}

		public function setLabel($label){
			$this->label = $label;
		}

		public function getLabel(){
			return $this->label;
		}

		public function addItem($subItems){
			$this->subItemss[] = $subItems;
		}

		public function getItems(){
			return $this->subItemss;
		}

		public function setAction($action){
			$this->action = $action;
		}

		public function getAction(){
			return $this->action;
		}


		public static function create($label , $type , $action){
			$menuItem = new MenuItem();
			$menuItem->setLabel($label);
			$menuItem->setType($type);
			$menuItem->setAction($action);

			return $menuItem;
		}
	}