
			<div id="publications" >
				<h1> Publications </h1>
				<?php

					// Start the Loop.
					$publication_ids = WPRI_Database::get_publication_ids();
					echo "<div class='container' >";
	    				foreach ( $publication_ids as $publication_id ) {
							$publication = WPRI_Database::get_publication_short($publication_id);
		   					echo "<a href='".site_url()."/publication?id=".$publication_id."'><div class='faculty-thumb col-md-5'>";
							echo "<tr><h3 class='faculty'>";
							echo $publication['title'];
							echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
