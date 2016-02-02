<?php 
	/*
		This scripts should run only if it is included by the application.
	 */
	global $_IN_SAME_APP ; 
	if(!isset($_IN_SAME_APP)){die("Not authorized access");}

	/*
		Include all the required classes for database usesage.
	*/
	require_once 'DatabaseConnection.php';
	require_once 'Statement.php';
	require_once 'PreparedStatement.php';
	require_once 'ResultSet.php';
	require_once 'DatabaseUtils.php';