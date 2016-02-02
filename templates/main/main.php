<?php /*Execute this script only by the application*/ global $_IN_SAME_APP ; if(!isset($_IN_SAME_APP)){die("Not authorized access");} ?>


<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="/templates/main/css/MainStyle.css" >

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
		
		<div class="container" id="Container">
			

			<div id="MenuBar" class="navbar navbar-default navbar-custom" role="navigation">
			    <div class="container-fluid">

			        <div class="navbar-header"><a class="navbar-brand" href="#">Crowd Game</a>
			            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			            </button>
			        </div>
			        <div class="collapse navbar-collapse navbar-menubuilder">
			        
			            <ul class="nav navbar-nav navbar-left">
			                <?php
			                	global $_CONFIG;
			                	print Utils::generateMenuListItems($_CONFIG["PRIMARY_MENU"]);
			                ?>
			            </ul>
			            
			            <ul class="nav navbar-nav navbar-right">
			                <?php
			                	global $_CONFIG;
			                	print Utils::generateMenuListItems($_CONFIG["SECONDARY_MENU"]);
			                ?>
			            </ul>
			        </div>

			    </div>
			</div>

			<div class="row" id="Section">
				<?php
					load("MAIN_CONTENT");
				?>
			</div>
			


		</div>
		
	</body>

</html>