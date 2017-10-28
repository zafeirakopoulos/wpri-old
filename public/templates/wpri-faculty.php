
			<div class='faculty' id="faculty" >
				<h1 class='faculty'> Faculty </h1>
				<?php

					// Start the Loop.
					$member_ids = WPRI_Database::get_member_ids();

					foreach ( $member_ids as $member_id ) {
						$member = WPRI_Database::get_member_short($member_id);
						echo "<a class='faculty-thumb-link' href='".site_url()."/member?id=".$member_id."'>";
							echo "<div class='col-sd-12 col-ld-5 col-md-9 faculty-thumb'>";
								echo "<table>";
									echo "<tr>";
										echo "<h3 class='faculty-thumb'>";
											echo $member['title']." ".$member['name'];
										echo "</h3>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>";
											echo get_avatar($member['user'] );
										echo "</td>";
										echo "<td>";
											echo "<p>";
												echo $member['position']."<br>";
												echo $member['website']."<br>";
												echo $member['email']."<br>";
											echo "</p>";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</div>";
						echo "</a>";
					}
				?>
			</div><!-- #faculty -->
