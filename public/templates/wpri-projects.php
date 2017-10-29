<div class='faculty' id="faculty" >
	<div class='container'>
 		<div class='row'>
			<?php
			// Start the Loop.
			$project_ids= WPRI_Database::get_project_ids();
			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_project_short($project_id);
				echo "<a class='project-thumb' href='".site_url()."/project?id=".$project_id."'>";
					echo "<div class='col-sm-12 col-md-5 col-lg-5 faculty-thumb-frame'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 faculty-thumb'><h1 class='faculty'>".$project['title']."</h1> </div>";
						echo "<div class='col-sm-3 col-md-3 col-lg-3 faculty-thumb'>".$project['status']."</div>";
						echo "<div class='col-sm-9 col-md-9 col-lg-9 faculty-thumb'>".$project['PI']."</div>";
					echo "</div>";
				echo "</a>";
			}
 			?>
		</div>
	</div>
</div><!-- #projects-->
