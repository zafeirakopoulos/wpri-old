
			<div class='project' id="project" >
				<?php
					$project_id=$_GET['id'];
					$project = WPRI_Database::get_project_full($project_id);

					echo "<br>";
					echo "<tr><h3 class='project'>";
					echo $project['title'];
					echo $project['position']."<br>";
					echo $project['website']."<br>";
					echo $project['email']."<br>";
					echo $project["funding"]."<br>";

					echo "Participants:<br>";
					echo "<table>";
					$project_members = WPRI_Database::get_project_members($project_id);
					foreach ($project_members as $member) {
						echo "<tr>";
		 				echo "<td>" . WPRI_Database::get_member($member->member)["name"]. "(". WPRI_Database::get_project_role($member->role).")<td>";
						echo "</tr>";
					}
					echo "</table>";

					echo "Publications:<br>";
					echo "<table>";
					$project_publications = WPRI_Database::get_project_publications($project_id);
					foreach ($project_publications as $publication) {
						echo "<tr>";
						$pub = WPRI_Database::get_publication($publication->pub);
						echo "<td><a href='".site_url()."/publication?id=".$pub->id."'>" . $pub->title."</a><td>";
						echo "</tr>";
					}
					echo "</table>";
				?>
			</div><!-- #member -->
