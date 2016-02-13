<?php
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ;
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	/*
		Contains utility functions that help
		reduce code repetition
	*/


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
				$html .= '><a href=".';
				$html .= self::generatePageLink($_MENUS[$menuName][$i]["page"]);
				$html .= '">'.$_MENUS[$menuName][$i]["label"].'</a></li>';
			}

			return $html;
		}


		/*
			Generates a like to page based on the config
		*/
		public static function generatePageLink($page){
			return "/?p=".$page;
		}


		/*
			Generates a page link that has parameters
		*/
		public static function genPageLinkWithParameters($page , $parameter , $value){
			return "/?p=".$page.'&'.$parameter.'='.$value;
		}

	}
