<div class='single' id="project" >
 		<div class='row'>
			<?php

			$project_id=$_GET['id'];
			$project = WPRI_Database::get_entity("project",$project_id);

  				echo "<div class='col-sm-12 listing-thumb-frame'>";
 						echo "<div class='col-xs-3  listing-thumb'>"."picture"."</div>";
						echo "<div class='col-xs-9 listing-thumb'><h1 class='listing'>".$project['title']."</h1> </div>";
 				echo "</div>";
 			?>


			<h2 class="single">Participants:</h2>

			<?php
				foreach ($project["members"] as $member_row) {
					$member = WPRI_Database::get_record("member",$member_row["member"]) ;
					echo "<a class=' single' href='".site_url()."/member?id=".$member["id"]."'>";
					echo "<div class='row'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$member["name"]. " (".
						WPRI_Database::get_localized("projectrole", $member_row["projectrole"]).")</div>";
					echo "</div>";
					echo "</a>";
				}
			?>


			<h2 class=" single">Publications:</h2>

			<?php
				foreach ($project["publication"] as $publication_id) {
					error_log("pub id:".$publication_id);
					$publication = WPRI_Database::get_record("publication",$publication_id) ;
					echo "<a class=' single' href='".site_url()."/publication?id=".$publication_id."'>";
					echo "<div class='row'>";
						echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$publication["official_title"]."</div>";
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
</div><!-- #project -->

<!--
echo "<div class='col-sm-12 listing-thumb-frame'>";
	echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>"."picture"."</div>";
	echo "<div class='row'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$project['title']."</h1> </div>";
	echo "</div>";
	echo "</a>";

	echo "<div class='row'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['status']."</div>";
		if (isset($project['website']) AND $project['website']!=""){
			echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['website']."</div>";
		}
		else{
			echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
			echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>".site_url()."/project?id=".$project_id."</a>";
			echo "</div>";
		}
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>PI: ".$project['PI']."</div>";
	echo "</div>"; -->
