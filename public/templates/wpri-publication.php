
			<div id="member" >
				<?php
					$member_id=$_GET['id'];
					$member = WPRI_Database::get_member($member_id);

					echo "<br>";
					echo "<table>";
					echo "<tr><h3 class='faculty'>";
					echo $member['title']." ".$member['name'];
					echo "</h3></tr>";
					echo "<tr><td>";
					echo get_avatar( $member['user'] );
					echo "</td>";
					echo "<td><p>";
					echo $member['position']."<br>";
					echo $member['website']."<br>";
					echo $member['email']."<br>";
					echo "</p></td></tr>";
					echo "</table>";

					echo "Publications:<br>";
					echo "<table>";
					$member_publications = WPRI_Database::get_member_publications($member_id);
					foreach ($member_publications as $publication) {
						echo "<tr>";
						$pub = WPRI_Database::get_publication($publication->pub);
						echo "<td><a href='".site_url()."/publication?id=".$pub->id."'>" . $pub->title."</a><td>";
						echo "</tr>";
					}
					echo "</table>";


					echo "Projects:<br>";
					echo "<table>";
					foreach ($member['projects'] as $project_member) {
						$project = WPRI_Database::get_project( $project_member->project);
						echo "<tr>";
		 				echo "<td>" . $project->title . "<td>";
						echo "<td>" . WPRI_Database::get_project_role($project_member->role) . "<td>";
		 				echo "<td>" . $project->PI . "<td>";
		 				echo "<td>" . $project->funding . "<td>";
						echo "</tr>";
					}
					echo "</table>";

					echo "Education:<br>";

				?>
			</div><!-- #member -->
