
			<div id="projects" >
				<h1> Projects </h1>
				<?php

					// Start the Loop.
					$project_ids = WPRI_Database::get_project_ids();
					echo "<div class='container' >";
	    				foreach ( $project_ids as $project_id ) {
							$project = WPRI_Database::get_project_short($project_id);
		   					echo "<a href='".site_url()."/project?id=".$project_id."'><div class='faculty-thumb col-md-5'>";
							echo "<tr><h3 class='faculty'>";
							echo $project['title'];
							echo $project['locale_description']."<br>";
							echo $project['status']."<br>";
							echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
