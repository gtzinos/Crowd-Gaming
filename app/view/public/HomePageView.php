<?php if($section == "CSS") : ?>
	<link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/HomePage.css"); ?>">
<?php elseif($section == "JAVASCRIPT") : ?>
	<script src="<?php print LinkUtils::generatePublicLink("js/public/HomePageEvents.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
	<div class="container-fluid">
		<center><h1> Welcome to <?php global $_CONFIG; echo $_CONFIG["FULL-APP-NAME"] ?> </h1> </center>
	  <br>
		<div id="main-carousel" class="carousel slide" data-ride="carousel">
				<!-- Carousel indicators -->

				<?php
					echo "<ol class='carousel-indicators'>";
							$images = array_diff(scandir("./res/slider"), array('..', '.'));
							$counter = 0;
							foreach($images as $image)
							{
								if(!is_dir($image))
								{
										 echo "<li data-target='#main-carousel' data-slide-to='" . $counter . "' " . ($counter == 0 ? "class='active'" : "") . "></li>";
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
		   <a class = "carousel-control left" href = "#main-carousel" data-slide = "prev">&lsaquo;</a>
		   <a class = "carousel-control right" href = "#main-carousel" data-slide = "next">&rsaquo;</a>

		</div>
	</div>
<!-- https://upload.wikimedia.org/wikipedia/commons/4/47/FPC_stats,_2007-2010.png -->


<?php endif; ?>
