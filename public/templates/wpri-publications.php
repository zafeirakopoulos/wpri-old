<div class='listing' id="publications" >
 		<div class='row'>
			<?php
			// Start the Loop.
			$publication_ids = WPRI_Database::get_ids("publication");
			foreach ( $publication_ids as $publication_id ) {
				$publication = WPRI_Database::get_entity("publication",$publication_id);
				echo "<div class='col-sm-12 listing-thumb-frame'>";
					echo "<a class='listing-thumb' href='".site_url()."/publication?id=".$publication_id."'>";
						echo "<div class='col-xs-1  listing-thumb'>";
                        if () {
                            echo "<img src='clarivate.png' alt='SCI indexed' height='42' width='100'>";
                        }
                        echo "</div>";
						echo "<div class='col-xs-11 listing-thumb'><h1 class='listing'>".$publication['title']."</h1> </div>";
					echo "</div>";
					echo "</a>";
				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #publications -->
