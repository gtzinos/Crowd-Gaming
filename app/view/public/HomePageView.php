<?php if($section == "CSS") : ?>
<style>
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
		width: 50%;
		margin: auto;
}
</style>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/HomePage.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
		<center><h1> Welcome to Crowd Gaming </h1> </center>
	  <br>
	  <div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
	      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	      <li data-target="#myCarousel" data-slide-to="1"></li>
	      <li data-target="#myCarousel" data-slide-to="2"></li>
	      <li data-target="#myCarousel" data-slide-to="3"></li>
	    </ol>

	    <!-- Wrapper for slides -->
	    <div class="carousel-inner" role="listbox">

	      <div class="item active">
	        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Responsive_Web_Design_for_Desktop,_Notebook,_Tablet_and_Mobile_Phone.png" alt="Chania" width="460" height="345">
	        <div class="carousel-caption">
	        </div>
	      </div>

	      <div class="item">
	        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Get_it_on_Google_play.svg/2000px-Get_it_on_Google_play.svg.png" alt="Chania" width="460" height="345">
	        <div class="carousel-caption">
						<h1></h1>
	        </div>
	      </div>

	      <div class="item">
	        <img src="https://upload.wikimedia.org/wikipedia/commons/1/11/Available_on_the_App_Store_(gray).png" alt="Flower" width="460" height="345">
	        <div class="carousel-caption">
	        </div>
	      </div>
				<div class="item">
	        <img src="https://upload.wikimedia.org/wikipedia/commons/4/47/FPC_stats,_2007-2010.png" alt="Flower" width="460" height="345">
	        <div class="carousel-caption">
	        </div>
	      </div>

	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	      <span class="sr-only">Previous</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	      <span class="sr-only">Next</span>
	    </a>
	  </div>
	</div>



<?php endif; ?>
