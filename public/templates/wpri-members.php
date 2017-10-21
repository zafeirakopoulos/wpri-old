
			<div id="members" >
				<h1> <?php echo 'Members' ?> </h1>
				<?php

					// Start the Loop.
					$members = $WPRI_Database::get_wp_member_ids() ;
    				foreach ( $members as $member_id ) {
    					$member = $WPRI_Database::get_wp_member($member_id);
						echo "<a href='".site_url()."/member?id=".$member->user."'><div class='faculty-thumb col-md-5'>";
                        echo "<table>";
                        echo "<tr><h3 class='faculty'>";
                        echo $member->title." ".$member->fname." ".$member->lname;
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
