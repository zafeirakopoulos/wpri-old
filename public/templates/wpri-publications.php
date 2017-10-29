<div class='faculty' id="publications" >
	<div class='container'>
 		<div class='row'>
			<?php
			// Start the Loop.
			$publication_ids = WPRI_Database::get_publication_ids();
			foreach ( $publication_ids as $publication_id ) {
				$publication = WPRI_Database::get_publication_short($publication_id);
				echo "<a class='faculty-thumb'  href='".site_url()."/publication?id=".$publication_id."'>";
					echo "<div class='col-sm-12 col-md-5 col-lg-5 faculty-thumb-frame'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 faculty-thumb'><h1 class='faculty'>".$publication['title']."</h1> </div>";
					echo "</div>";
				echo "</a>";
			}
 			?>
		</div>
	</div>
</div><!-- #publications-->
