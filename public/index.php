

<?php
	/*
			Starting point of this application
	*/
	session_start();

	 if(!@include_once("../src/core/Controller.php"))
	 {
			 header('Location: /');
	 }


	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800))
  {
			// last request was more than 30 minutes ago
			session_unset();     // unset $_SESSION variable for the run-time
			session_destroy();   // destroy session data in storage
	}

	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	/*
			Define pages that exist on this web sercive
	*/
	$pages = array(
			'signin'       => 'SignInController'         ,
			'signup'       => 'SignUpController'         ,
			'home'         => 'HomePageController'       ,
			'signout'      => 'SignoutController'
	);

	/*
			Check if the GET argument 'p' is set.
			If it isn't we set the target controller
			to default ('home').
			If it is we set the target controller
			the value of the GET argument
	*/
	if( !isset( $_GET['p'] ) )
			$target_controller = 'home';
	else
			$target_controller = $_GET['p'];

	/*
			We check if the controller to load
			exists in the $pages array.
			If it doesnt exist we set it to default
	*/
	if(!array_key_exists($target_controller , $pages))
			$target_controller = 'home';


  /*
      Include and create the right controller object
  */
	if(!@include_once('../src/controllers/'.$pages[$target_controller].'.php'))
	{
			header('Location: /');
	}

	$controller = new $pages[$target_controller];

  /*
      load the template
  */
	if(!@include_once('../src/views/index.html'))
	{
			header('Location: /');
	}


	?>
	</body>

	</html>
