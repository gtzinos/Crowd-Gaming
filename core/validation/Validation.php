<?php


	class Validation
	{
		
		public function checkNumericRange($value , $low , $high)
		{
			return ($values>=$low && $values<=$high);
		}

		public function checkStringLength($value , $min , $high)
		{
			return (strlen($values)>=$low && strlen($values)<=$high);
		}

		public function checkEmailFormat($value)
		{
			return filter_var($values, FILTER_VALIDATE_EMAIL);
		}

		public function checkValueInList($value , $valuesList)
		{

			foreach ($valuesList as $v) 
				if( $v == $value)
					return true;
			return false;
		}

	}
