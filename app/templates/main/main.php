<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<!-- Google Sign In -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="286669463790-ovcpq7noleth347mivsdd5s4vj8k90ah.apps.googleusercontent.com">
		<link rel="icon" href="./res/images/favicon.ico" type="image/x-icon" />
		<!-- Css files -->
		<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("res/foundation-icons/foundation-icons.css"); ?>" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/MainTemplateStyle.css"); ?>" >

		<script type="text/javascript">
			var webRoot = '<?php print '/'.$_CONFIG["WEB_ROOT"]; ?>';
			var googleApiKey = '<?php print $_CONFIG["GOOGLE_API_KEY"]; ?>';
			var googleReCaptchaKey = '<?php print $_CONFIG["CLIENT_GOOGLE_RECAPTCHA_KEY"]; ?>';
			var notCompletedRequest = false;
		</script>

		<!-- Script files -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!-- Google recaptcha -->
		<script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/library/spin.js"); ?>"></script>
		<!-- Tinymce editor -->
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/library/bootstrap-formvalidator/gt-formvalidator.js"); ?>"></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/common/spinner-call.js"); ?>"></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/library/noty/js/noty/packaged/jquery.noty.packaged.min.js"); ?>"> </script>
		<script src="<?php print LinkUtils::generatePublicLink("js/common/notification-box.js"); ?>"> </script>
		<?php
			if(!isset($_SESSION["USER_ID"]))
			{
				echo "
					<script src=" . LinkUtils::generatePublicLink("js/signIn.js") . "></script>
					<script src=" . LinkUtils::generatePublicLink("js/signup.js") . "></script>";
			}
			?>
		<script src="<?php print LinkUtils::generatePublicLink("js/public/MainTemplate.js"); ?>"></script>
		<script>
			var notCompletedWork = $.Deferred();
		</script>

		<title>
			<?php show("PAGE_TITLE") ?>
		</title>

		<?php
			load("CSS");
			load("JAVASCRIPT");
		?>
	</head>

	<body onkeypress="keyPressForm(event)">
		<!-- Menu bar place -->
		<nav class="navbar navbar-inverse">
		  	<div class="container-fluid">
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        		<span class="icon-bar"></span>
		        		<span class="icon-bar"></span>
		        		<span class="icon-bar"></span>
		      		</button>
		      		<a class="navbar-brand" href="./"><?php global $_CONFIG; echo $_CONFIG["SHORT-APP-NAME"] ?></a>
		    	</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
			            <?php
			               	print MenuRenderer::render( Menus::get(get("primary-menu")));
			            ?>
			        </ul>

			        <ul class="nav navbar-nav navbar-right">
			            <?php
			              	print MenuRenderer::render( Menus::get(get("secondary-menu")));
			            ?>
			        </ul>
			    </div>

			</div>
		</nav>

		<!-- Container place -->
		<div class="container" id="Container">
			<div class="row" id="Section">
				<?php
					load("MAIN_CONTENT");
				?>
			</div>
		</div>

		<?php
		if(!isset($_SESSION["USER_ID"]))
		{
			load("SIGN_IN");

			load("SIGN_UP");

	 		load("PASSWORD_RECOVERY");
		}
		?>
	</body>

</html>
