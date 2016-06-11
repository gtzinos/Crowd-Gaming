<?php if($section == "CSS") : ?>
<style>
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
		width: 60%;
		margin: auto;
}
</style>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/HomePage.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
		<center><h1> Welcome to Crowd Gaming </h1> </center>
	  <br>
		<div id = "myCarousel" class = "carousel slide">
				<!-- Carousel indicators -->

				<?php
					global $_CONFIG;
					echo "<ol class='carousel-indicators'>";
							$images = array_diff(scandir("./res/slider"), array('..', '.'));
							$counter = 0;
							foreach($images as $image)
							{
								if(!is_dir($image))
								{
										 echo "<li data-target='#myCarousel' data-slide-to='" . $counter . "' " . ($counter == 0 ? "class='active'" : "") . "></li>";
					 			}
								$counter++;
							}
					echo "</ol>";
					echo "<div class='carousel-inner'>";
					$counter = 0;
					foreach($images as $image)
					{
						if(!is_dir($image))
						{
					      echo "<div class='item " . ($counter == 0 ? "active" : "") . "'>
										    <img src='" . "res/slider/" . $image . "'>
								      </div>";
						}
						$counter++;
					}
					echo "</div>";
				?>
		   <!-- Carousel nav -->
		   <a class = "carousel-control left" href = "#myCarousel" data-slide = "prev">&lsaquo;</a>
		   <a class = "carousel-control right" href = "#myCarousel" data-slide = "next">&rsaquo;</a>

		</div>
	</div>
<!-- https://upload.wikimedia.org/wikipedia/commons/4/47/FPC_stats,_2007-2010.png -->


<?php endif; ?>
