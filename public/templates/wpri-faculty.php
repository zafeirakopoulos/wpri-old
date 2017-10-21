
			<div id="faculty" >
				<h1> Faculty </h1>
				<?php

					// Start the Loop.
					$member_ids = WPRI_Database::get_member_ids();
					$locale = 1; // TODO: read from the session
					echo "<div class='container' >";
	    				foreach ( $member_ids as $member_id ) {
							$member = WPRI_Database::get_member_short($member_id);
							echo "user:" + $member['user'];
		   					echo "<a href='".site_url()."/member?id=".$member->user."'><div class='faculty-thumb col-md-5'>";
							echo "<table>";
							echo "<tr><h3 class='faculty'>";
							echo $member->title." ".$member->name;
							echo "</h3></tr>";
							echo "<tr><td>";
							echo get_avatar( $member->user );
							echo "</td>";
							echo "<td><p>";
							echo $member->position."<br>";
							echo $member->website."<br>";
							echo $member->email."<br>";
							echo "</p></td></tr>";
							echo "</table>";
							echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
