<?php

	class LinkUtils{

		/*
			Generates a like to page based on the config
		*/
		public static function generatePageLink($page){
			global $_CONFIG;
			return "/".$_CONFIG["WEB_ROOT"].$page;
		}


		public static function generatePublicLink($asset){
			if(isset($_GET["path"])){
				$numberOfFolders = substr_count($_GET["path"] , "/");
				$path = "";
				for($i=0 ; $i < $numberOfFolders ; $i++)
					$path .= '../';

				return $path.$asset;
			}else{
				return './'.$asset;
			}
		}
		
	}
