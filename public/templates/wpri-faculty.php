
			<div class='faculty' id="faculty" >
				<h1 class='faculty'> Faculty </h1>
				<?php

					// Start the Loop.
					$member_ids = WPRI_Database::get_member_ids();
					foreach ( $member_ids as $member_id ) {
						echo $member_id;
					}
					echo "<div class='container>";
	    				foreach ( $member_ids as $member_id ) {
							$member = WPRI_Database::get_member_short($member_id);
							echo $member_id;
		   					echo "<a href='".site_url()."/member?id=".$member_id."'>";
							echo "<div class='col-md-5  faculty-thumb'>";
							echo "<table>";
							echo "<tr><h3 class='faculty-thumb'>";
							echo $member['title']." ".$member['name'];
							echo "</h3></tr>";
							echo "<tr><td>";
							echo get_avatar($member['user'] );
							echo "</td>";
							echo "<td><p>";
							echo $member['position']."<br>";
							echo $member['website']."<br>";
							echo $member['email']."<br>";
							echo "</p></td></tr>";
							echo "</table>";
							echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
