<div class='listing' id="publications" >
    <h1 class="single"> Publications </h1>
    <ul class="list-group">
			<?php
			$publication_ids = WPRI_Database::get_ids("publication");
			foreach ( $publication_ids as $publication_id ) {
				$publication = WPRI_Database::get_entity("publication",$publication_id);
 					echo "<a class='list-group-item' href='".site_url()."/publication?id=".$publication_id."'>";
						echo  $publication['title'] ;
					echo "</a>";
 			}
 			?>
    </ul>
 </div><!-- #publications -->
