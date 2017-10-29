<div class='faculty' id="positions" >
	<div class='container'>
 		<div class='row'>
			<?php
			// Start the Loop.
			$position_ids = WPRI_Database::get_open_position_ids();
			foreach ( $position_ids as $position_id ) {
				$position = WPRI_Database::get_open_position($position_id);
				echo "<a class='faculty-thumb' href='".site_url()."/position?id=".$position_id."'>";
					echo "<div class='col-sm-12 col-md-5 col-lg-5 faculty-thumb-frame'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 faculty-thumb'><h1 class='faculty'>".$position['title']."</h1> </div>";
						echo "<div class='col-sm-6 col-md-6 col-lg-6 faculty-thumb'>Deadline</div>";
						echo "<div class='col-sm-6 col-md-6 col-lg-6 faculty-thumb'>".$position['deadline']."</div>";
					echo "</div>";
				echo "</a>";
			}
 			?>
		</div>
	</div>
 </div><!-- #faculty -->
