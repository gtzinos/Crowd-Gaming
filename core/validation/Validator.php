<?php
	
	include "Validation.php";

	class Validator
	{

		const LENGTH_VALIDATION = 0;
		const RANGE_VALIDATION  = 1;
		const EMAIL_VALIDATION  = 2;
		const LIST_VALIDATION	= 3;


		private $validation;
		private $validations;

		public function __construct()
		{
			$validation = new Validation;
		}

		public function validate( $key , $value)
		{
			switch ( $validations[$key]["type"] ) 
			{
				case LENGTH_VALIDATION:
					return $validation->checkStringLength( $value , $validations[$key]["low"] ,$validations[$key]["high"] );
					break;
				case RANGE_VALIDATION:
					return $validation->checkNumericRange( $value , $validations[$key]["low"] ,$validations[$key]["high"] );
					break;
				case EMAIL_VALIDATION:
					return $validation->checkEmailFormat( $value );
					break;
				case LIST_VALIDATION:
					return $validation->checkStringLength( $value , $validations[$key]["list"] );
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