<div class='listing' id="projects" >
 		<div class='row'>
			<?php
            error_log("projects ");
            echo "test";
			// Start the Loop.
			$project_ids= WPRI_Database::get_ids("project");
            error_log(print_r($project_ids));

			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity("project",$project_id);
                error_log("project ".print_r($project));
				echo "<div class='col-sm-12 listing-thumb-frame'>";
					echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>"."picture"."</div>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$project['title']."</h1> </div>";
					echo "</div>";
					echo "</a>";

					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['status']."</div>";
						if (isset($project['website']) AND $project['website']!=""){
							echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['website']."</div>";
						}
						else{
							echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
							echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>".site_url()."/project?id=".$project_id."</a>";
							echo "</div>";
						}
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>PI: ".$project['PI']."</div>";
					echo "</div>";

				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #projects -->
