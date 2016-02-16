<?php
	include_once 'Menu.php';
	include_once 'MenuItem.php';
	include_once 'MenuRenderer.php';

	class Menus{

		private static $menus;

		public static function add($menu){
			self::$menus[$menu->getName()] = $menu;
		}

		public static function get($menu){
			return self::$menus[$menu];
		}

	}