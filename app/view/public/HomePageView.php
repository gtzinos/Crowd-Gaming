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

	</div>
<!-- https://upload.wikimedia.org/wikipedia/commons/4/47/FPC_stats,_2007-2010.png -->


<?php endif; ?>
