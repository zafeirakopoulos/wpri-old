
			<div class='faculty' id="faculty" >
				<h1 class='faculty'> Faculty </h1>
				<?php

					// Start the Loop.
					$member_ids = WPRI_Database::get_member_ids();

					foreach ( $member_ids as $member_id ) {
						$member = WPRI_Database::get_member_short($member_id);
						echo "<a class='faculty-thumb-link' href='".site_url()."/member?id=".$member_id."'>";
						echo "<div class='container'>";
							$member_id=$_GET['id'];
							$member = WPRI_Database::get_member($member_id);
							echo "<div class='row'>";
								echo "<div class='col-sm-12 col-md-12 col-lg-12'><h1>".$member['title']." ".$member['name']."</h1> </div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-sm-3 col-md-3 col-lg-3'>".get_avatar( $member['user'] )."</div>";
								echo "<div class='col-sm-3 col-md-3 col-lg-3'>".$member['position']."</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-sm-3 col-md-3 col-lg-3'>".$member['website']."</div>";
						echo "<div class='col-sm-3 col-md-3 col-lg-3'>".$member['email']."</div>";
						echo "</div>";
						echo "</div></a>";
					}
				?>
			</div><!-- #faculty -->
