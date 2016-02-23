<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<!-- Css files -->
		<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/MainTemplateStyle.css"); ?>" >
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- Script files -->
		<script src="<?php print LinkUtils::generatePublicLink("js/signIn.js"); ?>"></script>
		<script src="<?php print LinkUtils::generatePublicLink("js/library/spin.js"); ?>"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<title>
			<?php show("PAGE_TITLE") ?>
		</title>

		<?php
			load("CSS");
			load("JAVASCRIPT");
		?>
	</head>

	<body>
		<!-- Menu bar place -->
		<nav class="navbar navbar-inverse">
		  	<div class="container-fluid">
		    	<div class="navbar-header">
		      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        		<span class="icon-bar"></span>
		        		<span class="icon-bar"></span>
		        		<span class="icon-bar"></span>
		      		</button>
		      		<a class="navbar-brand" href="./">Crowd Game</a>
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
			load("SIGN_IN");

			load("SIGN_UP");
		?>
	</body>

</html>