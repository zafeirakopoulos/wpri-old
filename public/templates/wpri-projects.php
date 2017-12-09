<div class='listing' id="projects" >
 		<div class='row'>
			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity("project",$project_id);
					echo "<a class='listing-thumb-frame' href='".site_url()."/project?id=".$project_id."'>";
						echo "<div class='col-xs-3  listing-thumb'>"."picture"."</div>";
						echo "<div class='col-xs-9 listing-thumb'><h1 class='listing'>".$project['title']."</h1> </div>";
					echo "</a>";
			}
 			?>
		</div>
 </div><!-- #projects -->
