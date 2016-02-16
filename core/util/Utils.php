<?php
	/*
		Contains utility functions that help
		reduce code repetition
	*/
	include_once 'LinkUtils.php';


	class Utils{

		/*
			Generates html list items from the requested menu.
			the li contain the proper link to pages
		*/
		public static function generateMenuListItems($menuName){
			global $_MENUS;

			$html = "";

			for($i = 0 ; $i < sizeof($_MENUS[$menuName]) ; $i++){
				$html .= '<li ';
				if($_SESSION["CURRENT_PAGE"] == $_MENUS[$menuName][$i]["page"])
					$html .= 'class="active"';
				$html .= '><a href="';
				$html .= LinkUtils::generatePageLink($_MENUS[$menuName][$i]["page"]);
				$html .= '">'.$_MENUS[$menuName][$i]["label"].'</a></li>';
			}

			return $html;
		}

	}
