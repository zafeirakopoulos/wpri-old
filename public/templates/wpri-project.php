
			<div id="project" >
				<?php
					$project_id=$_GET['id'];
					$project = WPRI_Database::get_project_full($project_id);

					echo "<br>";
					echo $_SESSION['locale'];
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
				?>
			</div><!-- #member -->
