<div class='listing' id="faculty" >
 		<div class='row'>
			<?php
			// Start the Loop.
			$publication_ids = WPRI_Database::get_publication_ids();
			foreach ( $publication_ids as $publication_id ) {
				$publication = WPRI_Database::get_publication_short($publication_id);
				echo "<div class='col-sm-12 listing-thumb-frame'>";
					echo "<a class='listing-thumb' href='".site_url()."/publication?id=".$publication_id."'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>"."picture"."</div>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$publication['title']." ".$member['name']."</h1> </div>";
					echo "</div>";
					echo "</a>";
				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #publications -->
