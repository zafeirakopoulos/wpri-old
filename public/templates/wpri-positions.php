<div class='listing' id="positions" >
	<div class='container'>
 		<div class='row'>
			<?php
			// Start the Loop.
			$position_ids = WPRI_Database::get_open_position_ids();
			foreach ( $position_ids as $position_id ) {
				$position = WPRI_Database::get_open_position($position_id);
				echo "<a class='listing-thumb' href='".site_url()."/position?id=".$position_id."'>";
					echo "<div class='listing-thumb-frame'>";
						echo "<div class='row'>";
							echo "<div class='col-sm-12 col-md-12 col-lg-12 listing-thumb'><h1 class='faculty'>".$position['title']."</h1> </div>";
						echo "</div>";
						echo "<div class='row'>";
							echo "<div class='col-sm-3 col-md-3 col-lg-3 listing-thumb'>Deadline</div>";
							echo "<div class='col-sm-9 col-md-9 col-lg-9 listing-thumb'>".$position['deadline']."</div>";
						echo "</div>";
					echo "</div>";
				echo "</a>";
			}
 			?>
		</div>
	</div>
 </div><!-- #faculty -->
