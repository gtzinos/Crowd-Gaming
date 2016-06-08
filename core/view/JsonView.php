<?php

	class JsonView extends View
	{
		public function display($output)
		{
			header('Content-Type: application/json');
            print json_encode($output);
		}
	}
