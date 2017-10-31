<div class="single-frame">

		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member($member_id);
		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class="single"> <?php echo $member['title']." ".$member['name'];?></h1> </div>
		</div>
		<div class='row'>
			<!-- <div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo get_avatar( $member['user'] , 96, 'left'); ?> </div> -->
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo get_avatar($member['user']); ?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['position'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['website'];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['email'];?> </div>
		</div>


	    <hr/>
	    <h2 class="single">Publications</h2>
	    <hr/>
	

		<?php
		$member_publications = WPRI_Database::get_member_publications($member_id);
		foreach ($member_publications as $publication) {
			$pub = WPRI_Database::get_publication($publication->pub);
			echo "<a class='single' href='".site_url()."/publication?id=".$pub->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$pub->title."</div>";
			echo "</div>";
			echo "</a>";
			if !($publication === end($member_publications)){
				echo "<hr />";
			}
		}?>


 
	    <hr/>
	    <h2 class="single">Projects</h2>
	    <hr/>
	
 
 

		<?php 
		$projects = $member['projects'];
		foreach ($projects as $project_member) {
			$project = WPRI_Database::get_project( $project_member->project);
			echo "<a class='single' href='".site_url()."/project?id=".$project->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-9 col-lg-9 single'>".$project->title."</div>";
				echo "<div class='col-sm-12 col-md-3 col-lg-3 single'>".$project->funding."</div>";
			echo "<div class='row'>";
			echo "</div>";
				$pi = WPRI_Database::get_member($project->PI);
				echo "<div class='col-sm-12 col-md-5 col-lg-5 single'>".$pi["title"]." ".$pi["name"]."</div>";
				echo "<div class='col-sm-12 col-md-3 col-lg-3 single'>". WPRI_Database::get_project_role($project_member->role)."</div>";

			echo "</div>";
			echo "</a>";
			if !($project_member === end($projects)){
				echo "<hr />";
			}

		}?>

 
	    <hr/>
	    <h2 class="single">Education</h2>
	    <hr/>
	
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class="single"> <?php echo $member['title']." ".$member['name'];?></h1> </div>
		</div>
		<div class='row'>
			<!-- <div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo get_avatar( $member['user'] , 96, 'left'); ?> </div> -->
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo get_avatar($member['user']); ?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['position'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['website'];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['email'];?> </div>
		</div>


 
	    <hr/>
	    <h2 class="single">News</h2>
	    <hr/>
	<?php $args = array(
			  'author__in'     => array($member['user']),
			  'posts_per_page' => 20,
			  'post_type' => 'wpri_news'
			);

			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post();
				echo "<div class='row'>";
					echo "<a class='single' href='".site_url()."/news/".$post->post_name."'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12  single'>".the_title()."</div>";
					echo "</a>";
				echo "</div>";

			endwhile;

		?>
</div><!-- #member -->
