
<html>
	<head>
		<title>Treasure-Thess ( The Treasure Hunter game for Thessaloniki - Greece )</title
		<link rel="icon" type="image/ico" href="./resources/ico/logo.ico">

	</head>
	<body>
	<?php
		/*
			Json Header
		*/

		/*
			Include config file and connect to the database
		*/
		include("./config.php");

		printtable("select * from Users",$link);

	    function printtable($sql, $conn) {
			 	 $result = $conn->query($sql);
				 $i=0;
				 while ($row = $result->fetch_assoc()){
			        $farray[] = $row;
			 		}
			 	 echo json_encode($farray);						
	   }
		$link->close();
	?>
	</body>

	</html>
