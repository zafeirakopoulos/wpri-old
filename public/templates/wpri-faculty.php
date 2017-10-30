<div class='faculty' id="faculty" >
 		<div class='row'>
			<?php
			// Start the Loop.
			$member_ids = WPRI_Database::get_member_ids();
			foreach ( $member_ids as $member_id ) {
				$member = WPRI_Database::get_member_short($member_id);

				echo "<div class='col-sm-12 faculty-thumb-frame'>";
				echo "<a class='faculty-thumb' href='".site_url()."/member?id=".$member_id."'>";
				echo "<div class='col-xs-3 faculty-thumb'>".get_avatar( $member['user'])."</div>";
				echo "</a>";
				// echo "<div class='col-xs-9 faculty-thumb'>";
					echo "<div class='row'>";
					echo "<div class='col-xs-3 faculty-thumb'><h1 class='faculty'>".$member['title']." ".$member['name']."</h1> </div>";
					echo "</div>";
					echo "<div class='col-xs-3 faculty-thumb'>".$member['position']."</div>";
					echo "<div class='col-xs-3 faculty-thumb'>".$member['website']."</div>";
					echo "<div class='col-xs-3 faculty-thumb'>".$member['email']."</div>";
				// echo "</div>";


				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #faculty -->
