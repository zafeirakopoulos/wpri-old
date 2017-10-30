<div class='listing' id="faculty" >
 		<div class='row'>
			<?php
			// Start the Loop.
			$position_ids = WPRI_Database::get_open_position_ids();
			foreach ( $position_ids as $position_id ) {
				$position = WPRI_Database::get_open_position($position_id);
				echo "<div class='col-sm-12 listing-thumb-frame'>";
					echo "<a class='listing-thumb' href='".site_url()."/position?id=".$position_id."'>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-12 col-ld-12 listing-thumb'><h1 class='listing'>".$position['title']."</h1> </div>";
					echo "</div>";
					echo "</a>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>Deadline:</div>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$position['deadline']."</div>";
					echo "</div>";
				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #positions-->
