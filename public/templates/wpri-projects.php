
			<div id="projects" >
				<h1> <?php echo 'Projects' ?> </h1>
				<?php
					$current_language = "en";
					// This has to be done using js. Cannot be written in DB for example.
					// Have a hidden element in the DOM to keep track of language.

					// Start the Loop.
					$projects = get_wpri_projects();
					echo "<div class='container' >";

    				foreach ( $projects as $project) {

						echo "<a href='".site_url()."/member?id=".$member->user."'><div class='faculty-thumb col-md-5'>";
                        echo "<table>";
                        echo "<tr><h3 class='faculty'>";
                        echo $atitle." ".$fname." ".$lname;
                        echo "</h3></tr>";
                        echo "<tr><td>";
                        echo get_avatar( $member->user );
                        echo "</td>";
                        echo "<td><p>";
                        echo $position."<br>";
                        echo $member->website."<br>";
                        echo $email."<br>";
                        echo "</p></td></tr>";
                        echo "</table>";
                        echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #projects -->
