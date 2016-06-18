<?php
	
	include "Validation.php";

	class Validator
	{

		const LENGTH_VALIDATION = 0;
		const RANGE_VALIDATION  = 1;
		const EMAIL_VALIDATION  = 2;
		const LIST_VALIDATION	= 3;

		private $validations;

		public function __construct()
		{
			$this->validations = array();
		}

		public function validate( $key , $value)
		{
			$validation = new Validation;
			switch ( $this->validations[$key]["type"] ) 
			{
				case self::LENGTH_VALIDATION:
					return $validation->checkStringLength( $value , $this->validations[$key]["low"] ,$this->validations[$key]["high"] );
					break;
				case self::RANGE_VALIDATION:
					return $validation->checkNumericRange( $value , $this->validations[$key]["low"] ,$this->validations[$key]["high"] );
					break;
				case self::EMAIL_VALIDATION:
					return $validation->checkEmailFormat( $value );
					break;
				case self::LIST_VALIDATION:
					return $validation->checkStringLength( $value , $this->validations[$key]["list"] );
					break;
			}
		}

		public function registerRangeValidation( $key , $low , $high)
		{
			$validations[$key]["type"] = self::RANGE_VALIDATION;
			$validations[$key]["low"] = $low;
			$validations[$key]["high"] = $high;
		}

		public function registerLengthValidation( $key , $low , $high)
		{
			$validations[$key]["type"] = self::LENGTH_VALIDATION;
			$validations[$key]["low"] = $low;
			$validations[$key]["high"] = $high;
		}

		public function registerEmailCheck( $key )
		{
			$validations[$key]["type"] = self::EMAIL_VALIDATION;
		}

		public function registerListCheck( $key , $valuesList)
		{
			$validations[$key]["type"] = self::LIST_VALIDATION;
			$validations[$key]["list"] = $valuesList;
		}
	}