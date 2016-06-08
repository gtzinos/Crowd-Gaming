<?php

	$validator = new Validator;


	/*
		User Data 
	 */
	$validator->registerLengthValidation("FIRST_NAME" , 2 , 40);
	$validator->registerLengthValidation("SURNAME" , 2 , 40);
	$validator->registerEmailCheck("EMAIL_CHECK");
	$validator->registerLengthValidation("PASSWORD" , 8 , 300);
	$validator->registerLengthValidation("CITY" , 2 , 40);
	$validator->registerLengthValidation("COUNTRY" , 2 , 40);
	$validator->registerLengthValidation("ADDRESS" , 2 , 40);
	$validator->registerLengthValidation("PHONE" , 8 , 15);

	$validator->registerLengthValidation("MESSAGE_SIZE" , 19 , 255);

	$validator->registerLengthValidation("QUESTIONNAIRE_NAME" , 19, 255);
	$validator->registerLengthValidation("QUESTIONNAIRE_DESC" , 30, PHP_INT_MAX);