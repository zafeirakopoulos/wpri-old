
			<div class="member">
				<table>
				<tr><h3>
					<?php
						$member_id=$_GET['id'];
						$member = WPRI_Database::get_member($member_id);
						$member['title']." ".$member['name'];?>
				</h3></tr>
				<tr><td>
					<?php echo get_avatar( $member['user'] );?>
				</td>
				<td><p>
					<?php echo $member['position'];?>
				<br>
					<?php echo $member['website'];?>
				<br>
					<?php echo $member['email'];?>
				<br>
				</p></td></tr>
				</table>

				<h2 class="member">Publications:</h2>
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


				<h2 class="member">Projects:</h2>
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

				<h2 class="member">Education:</h2>

				<h2 class="member">News:</h2>

				<?php $args = array(
						  'author__in'     => array($member['user']),
						  'posts_per_page' => 20,
						  'post_type' => 'wpri_news'
						);

						$loop = new WP_Query( $args );
						echo "<ol>";
						while ( $loop->have_posts() ) : $loop->the_post();
							echo "<li><a class='member' href='".site_url()."/news/".$post->post_name."'>";
									the_title();
							echo "</a></li>";
						endwhile;
						echo "</ol>";


 				?>
			</div><!-- #member -->
