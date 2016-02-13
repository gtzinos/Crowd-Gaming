<?php /*Execute this script only by the application*/ global $_IN_SAME_APP ; if(!isset($_IN_SAME_APP)){die("Not authorized access");} ?>


<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">

		<link rel="stylesheet" href="./templates/main/css/MainStyle.css" >
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


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
	                	global $_CONFIG;
	                	print Utils::generateMenuListItems($_CONFIG["PRIMARY_MENU"]);
	                ?>
	            </ul>

	            <ul class="nav navbar-nav navbar-right">
	                <?php
	                	global $_CONFIG;
	                	print Utils::generateMenuListItems($_CONFIG["SECONDARY_MENU"]);
	                ?>
										<button type="button" data-loading-text="Loading.." data-toggle="modal" data-target="#loginModal" class="btn btn-primary round">Login</button>
										<button type="button" data-loading-text="Loading.." data-toggle="modal" data-target="#registerModal" class="btn btn-primary round">Sign Up</button>
	            </ul>
	        </div>

	    </div>
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

	</body>

</html>

<!--Register Modal -->
 <div class="modal fade" id="loginModal" role="dialog">
	 <div class="modal-dialog modal-md">
		 <div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h1 class="modal-title form-title">Login Page</h1>
			 </div>
			 <div class="modal-body">
					<form role="form">
							<div class="form-group">
									<label for="email">Email</label>
							 	  <input class="form-control" type="email"  placeholder="Email">
							</div>
							<div class="form-group">
								<label for="pwd">Password:</label>
								<input type="password" class="form-control" placeholder="Password">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" /> Remember Me
								</label>
							</div>
					</form>
			 </div>
			 <div class="modal-footer">
				 <button type="button" class="btn btn-primary btn-md round">Sign In</button>
				 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
			 </div>
		 </div>
	 </div>
 </div>

<!--Register Modal -->
 <div class="modal fade" id="registerModal" role="dialog">
	 <div class="modal-dialog modal-md">
		 <div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 <h1 class="modal-title form-title">Register Page</h1>
			 </div>
			 <div class="modal-body">
						<form role="form">
							 <div class="form-group">
								   <label>First Name</label>
							 		<input class="form-control" type="text"  placeholder="First Name" />
							 </div>
							 <div class="form-group">
									<label>Last Name</label>
							 		<input class="form-control" type="text"  placeholder="Last Name" />
							 </div>
							 <div class="form-group">
									<label for="email">Email</label>
							 	  <input class="form-control" type="email"  placeholder="Email">
							</div>
							<div class="form-group">
								<label for="pwd">Password:</label>
								<input type="password" class="form-control" placeholder="Password">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" />Accept licence
								</label>
							</div>

						</form>
				</div>
			 <div class="modal-footer">
				 <button type="button" class="btn btn-primary btn-md round">Sign Up</button>
				 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
			 </div>
		 </div>
	 </div>
 </div>
