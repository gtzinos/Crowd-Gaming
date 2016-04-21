<?php

	class MenuRenderer
	{
			

		/**
		 * Generates the corresponding html for a menu
		 * @param  [Menu] $menu [The menu object]
		 * @return [string]       [html]
		 */
		public static function render($menu)
		{
			$output = "";

			foreach ($menu->getItems() as $menuItem) 
			{
				$output .= self::renderItem($menuItem);
			}

			return $output;
		}

		private static function renderItem($menuItem)
		{
			$output = "";

			if($_SESSION["CURRENT_PAGE"] == $menuItem->getAction() )
				$output .= '<li class="active" >';
			else
				$output .= '<li>';

			if($menuItem->getType() == "LINK")
			{

				$output .= '<a href="'.LinkUtils::generatePageLink($menuItem->getAction()).'" >'.$menuItem->getLabel().'</a>';

			}
			else if($menuItem->getType() == "MODAL")
			{
				$output .= '<a data-loading-text="Loading.." data-toggle="modal" data-target="'.$menuItem->getAction().'"  class="modal-link">'.$menuItem->getLabel().'</a>';
			}
			else if($menuItem->getType() == "DROPDOWN")
			{

				$output .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$menuItem->getLabel().'<span class="caret"></span></a>';
				$output .= '<ul class="dropdown-menu">';

				foreach ($menuItem->getItems() as $subItem) 
				{
					$output .= self::renderItem($subItem);
				}

				$output .= '</ul>';
			}

			$output .= "</li>";

			return $output;
		}

	}