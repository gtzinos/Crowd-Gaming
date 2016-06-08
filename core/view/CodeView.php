<?php

	class CodeView extends View
	{
		public function display($output)
		{
			print $output["response-code"];
		}
	}
