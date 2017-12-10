<div class='single' id="member" >
 		<div class='row'>
			<?php

			$member_id=$_GET['id'];
			$member = WPRI_Database::get_member_full($member_id);

 			echo "<div class='row'>
	        <a href='".site_url()."/member?id=".$member["id"]."' class='single'>
	                <div class='col-xs-8 offset-xs-2 single'>
	                    <div class='col-xs-12 single'><h1 class='single'>".$member["title"]." ".$member['name']."</h1></div>
	                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
	                    <div class='col-xs-9 single'>".$member['position']."</div>
	                </div>
	            </a>
	            </div>
	          <hr/>";

			echo "<div class='col-xs-3  single'>"."picture"."</div>";
			echo "<div class='col-xs-9 single'><h4 class='listing'>".$project['title']."</h4> </div>";

			echo "<div class='col-xs-12 single'><h4 class='listing'> Status:".$project['status']."</h4> </div>";

			if (isset($project['website']) AND $project['website']!=""){
				echo "<div class='col-xs-12 single'><h4 class='listing'>".$project['website']."</h4></div>";
			}

			echo "<div class='col-xs-12 single'><h4 class='listing'> Activity Period:".
				mysql2date( 'F j, Y', $project['startdate'] )
				."-".
				mysql2date( 'F j, Y', $project['enddate'] )
				."</h4> </div>";

			echo "<div class='col-xs-12 single'><h4 class='listing'> Funded by:".join(",",$project['agency'])."</h4> </div>";
 			?>


			<h2 class="single">Participants</h2>
			<h3 class="single">Institute members</h3>

			<?php
				foreach ($project["members"] as $member_row) {
					$member = WPRI_Database::get_record("member",$member_row["member"]) ;
					echo "<a class=' single' href='".site_url()."/member?id=".$member["id"]."'>";
					echo "<div class='row'>";
						echo "<div class='col-sm-12 single'>".$member["name"]. " (".
						WPRI_Database::get_localized("projectrole", $member_row["projectrole"]).")</div>";
					echo "</div>";
					echo "</a>";
				}
			?>


			<?php
				if (!empty($project["collaborators"])){
					echo "<h3 class='single'>Collaborators</h3>";
					foreach ($project["collaborators"] as $collaborators_row) {
						$member = WPRI_Database::get_record("collaborator",$collaborators_row["collaborator"]) ;
						echo "<div class='col-sm-12 single'>".$member["name"]. " (".WPRI_Database::get_localized("projectrole", $collaborators_row["projectrole"]).")</div>";
					}
				}

			?>



			<h2 class=" single">Publications</h2>

			<?php
				foreach ($project["publication"] as $publication_id) {
					error_log("pub id:".$publication_id);
					$publication = WPRI_Database::get_record("publication",$publication_id) ;
					echo "<a class=' single' href='".site_url()."/publication?id=".$publication_id."'>";
					echo "<div class='row'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$publication["title"]."</div>";
					echo "</div>";
					echo "</a>";
				}
			?>

		</div>
</div><!-- #project -->








	<!--
	<h2 class="member">News:</h2>
	Needs work. From project management connect a wpri_news post with the project to query from here.
	-->








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
			if (!($publication === end($member_publications))){
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
			if (!($project_member === end($projects))){
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
