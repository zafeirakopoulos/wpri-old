
			<div id="projects" >
				<h1> Projects </h1>
				<?php

					// Start the Loop.
					$project_ids = WPRI_Database::get_project_ids();
					echo "<div class='container' >";
	    				foreach ( $project_ids as $project_id ) {
							$project = WPRI_Database::get_project_short($project_id);
		   					echo "<a href='".site_url()."/project?id=".$project_id."'><div class='project-thumb col-md-10'>";
							echo "<h3 class='project-thumb'>";
							echo $project['title'];
							echo "</h3>";
							echo "<p>";
							echo $project['locale_description']."<br>";
							echo $project['status']."<br>";
							echo "</p>";
							echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
