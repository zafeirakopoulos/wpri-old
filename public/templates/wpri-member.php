
			<div class="member">
				<div class="container">
					<?php
					$member_id=$_GET['id'];
					$member = WPRI_Database::get_member($member_id);
					?>
					<div class='row'>
						<div class='col-sm-12 col-md-12 col-lg-12'><h1> <?php echo $member['title']." ".$member['name'];?></h1> </div>
					</div>
					<div class='row'>
						<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo get_wp_user_avatar( $member['user'] , 96, 'left'); ?> </div>
						<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $member['position'];?> </div>
					</div>
					<div class='row'>
						<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $member['website'];?> </div>
						<div class='col-sm-3 col-md-3 col-lg-3'> 	<?php echo $member['email'];?> </div>
					</div>
				</div>


				<h2 class="member">Publications:</h2>
				<div class="container">
					<?php
					$member_publications = WPRI_Database::get_member_publications($member_id);
					foreach ($member_publications as $publication) {
						$pub = WPRI_Database::get_publication($publication->pub);
						echo "<a class='member' href='".site_url()."/publication?id=".$pub->id."'>";
						echo "<div class='row'>";
							echo "<div class='col-sm-12 col-md-12 col-lg-12'>".$pub->title."</div>";
						echo "</div>";
						echo "</a>";
					}?>
				</div>

				<h2 class="member">Projects:</h2>
				<div class="container">
					<?php foreach ($member['projects'] as $project_member) {
						$project = WPRI_Database::get_project( $project_member->project);
						echo "<a class='member' href='".site_url()."/project?id=".$project->id."'>";
						echo "<div class='row'>";
							echo "<div class='col-sm-4 col-md-4 col-lg-4'>".$project->title."</div>";
							echo "<div class='col-sm-2 col-md-2 col-lg-2'>". WPRI_Database::get_project_role($project_member->role)."</div>";
							echo "<div class='col-sm-2 col-md-2 col-lg-2'>".$project->PI."</div>";
							echo "<div class='col-sm-2 col-md-2 col-lg-2'>".$project->funding."</div>";
						echo "</div>";
						echo "</a>";
					}?>
				</div>

				<h2 class="member">Education:</h2>

				<h2 class="member">News:</h2>

				<?php $args = array(
						  'author__in'     => array($member['user']),
						  'posts_per_page' => 20,
						  'post_type' => 'wpri_news'
						);

						$loop = new WP_Query( $args );
						echo "<div class='container'>";
						while ( $loop->have_posts() ) : $loop->the_post();
							echo "<a class='member' href='".site_url()."/news/".$post->post_name."'>";
								echo "<div class='row'>";
									echo "<div class='col-sm-12 col-md-12 col-lg-12'>".the_title()."</div>";
								echo "</div>";
							echo "</a>";
						endwhile;
						echo "</div>";


 				?>
			</div><!-- #member -->
