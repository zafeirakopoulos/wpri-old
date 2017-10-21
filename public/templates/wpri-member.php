
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

					echo "Education:<br>";

					echo "Projects:<br>";
					echo "<table>";
					foreach ($member['projects'] as $project) {
						echo "<tr>";
		 				echo "<td>" . $project->title . "<td>";
		 				echo "<td>" . $project->PI . "<td>";
		 				echo "<td>" . $project->funding . "<td>";
						echo "</tr>";
					}
					echo "</table>";
				?>
			</div><!-- #member -->
