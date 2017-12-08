<div class='listing' id="faculty" >
 		<div class='row'>
			<?php
			// Start the Loop.
			$member_ids = WPRI_Database::get_member_ids();
			foreach ( $member_ids as $member_id ) {
				$member = WPRI_Database::get_member_short($member_id);
				echo "<div class='col-sm-12 listing-thumb-frame'>";
					echo "<a class='listing-thumb' href='".site_url()."/member?id=".$member_id."'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>".get_avatar( $member['user'])."</div>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$member['title']." ".$member['name']."</h1> </div>";
					echo "</div>";
					echo "</a>";
					echo "<div class='row'>";
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['position']."</div>";
						if (isset($member['website']) AND $member['website']!=""){
							echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['website']."</div>";
						}
						else{
							echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
							echo "<a class='listing-thumb' href='".site_url()."/member?id=".$member_id."'>".site_url()."/member?id=".$member_id."</a>";
							echo "</div>";
						}
						echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['email']."</div>";
					echo "</div>";

				echo "</div>";
			}
 			?>
		</div>
 </div><!-- #faculty -->
