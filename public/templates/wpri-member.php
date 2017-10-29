
			<div id="member" class="member">
				<?php
					$member_id=$_GET['id'];
					$member = WPRI_Database::get_member($member_id);
				?>
				<br>
				<table>
				<tr><h3>
				<?php$member['title']." ".$member['name'];?>
				</h3></tr>
				<tr><td>
					<?php get_avatar( $member['user'] );?>
				</td>
				<td><p>
					<?php $member['position'];?>
				<br>
					<?php $member['website'];?>
				<br>
					<?php $member['email'];?>
				<br>
				</p></td></tr>
				</table>

				<h2>Publications:</h2><br>
					<table>
					<?php $member_publications = WPRI_Database::get_member_publications($member_id);
					foreach ($member_publications as $publication) {
						echo "<tr>";
						$pub = WPRI_Database::get_publication($publication->pub);
						echo "<td><a href='".site_url()."/publication?id=".$pub->id."'>" . $pub->title."</a><td>";
						echo "</tr>";
					}
					?>
					</table>


				<h2>Projects:</h2><br>
				<table>
				<?php foreach ($member['projects'] as $project_member) {
						$project = WPRI_Database::get_project( $project_member->project);
						echo "<tr>";
		 				echo "<td>" . $project->title . "<td>";
						echo "<td>" . WPRI_Database::get_project_role($project_member->role) . "<td>";
		 				echo "<td>" . $project->PI . "<td>";
		 				echo "<td>" . $project->funding . "<td>";
						echo "</tr>";
					}?>
				</table>

				<h2>Education:</h2><br>

				<h2>News:</h2><br>

				<?php $args = array(
						  'author__in'     => array($member['user']),
						  'posts_per_page' => 20,
						  'post_type' => 'wpri_news'
						);

						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) : $loop->the_post();
							echo "<a href='".site_url()."/news/".$post->post_name."'>";
								echo '<div>';
								the_title();
				  				echo '</div>';
							echo "</a>";
						endwhile;
 				?>
			</div><!-- #member -->
