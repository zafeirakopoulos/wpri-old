<div class='single' id="project" >
 		<ul class='list-group'>
			<?php

			$project_id=$_GET['id'];
			$project = WPRI_Database::get_entity("project",$project_id);

            echo "<div class='col-xs-8  list-group-item-alt '>";

			echo "<div class='col-xs-9'><h2 class='list-item-alt'>".$project['title']."</h2> </div>";

			echo "<div class='col-xs-12'><h3 class='list-item-alt'> Status: ".$project['status']."</h3> </div>";

			if (isset($project['website']) AND $project['website']!=""){
				echo "<div class='col-xs-12 single'><h3 class='list-item-alt'>".$project['website']."</h3></div>";
			}

			echo "<div class='col-xs-12 single'><h3 class='list-item-alt'> Activity Period: ".
				mysql2date( 'F j, Y', $project['startdate'] )
				."-".
				mysql2date( 'F j, Y', $project['enddate'] )
				."</h3> </div>";

			echo "<div class='col-xs-12 single'><h3 class='list-item-alt'> Funded by: ".join(",",$project['agency'])."</h3> </div>";
            echo "<div class='col-xs-3'>"."picture"."</div>";
            echo "</div>";
 			?>
</ul>

			<h2 class="outfont">Participants</h2>
			<h3 class="outfont">Institute members</h3>
			<ul class="list-group">
			<?php
				foreach ($project["members"] as $member_row) {
					$member = WPRI_Database::get_record("member",$member_row["member"]) ;
					echo "<a class='list-group-item' href='".site_url()."/member?id=".$member["id"]."'>";
 					echo $member["name"]. " (".WPRI_Database::get_localized("projectrole", $member_row["projectrole"]).")";
 					echo "</a>";
				}
			?>
			</ul>

			<?php
				if (!empty($project["collaborators"])){
					echo "<h3 class='single'>Collaborators</h3>";
					foreach ($project["collaborators"] as $collaborators_row) {
						$member = WPRI_Database::get_record("collaborator",$collaborators_row["collaborator"]) ;
						echo "<div class='col-sm-12 single'>".$member["name"]. " (".WPRI_Database::get_localized("projectrole", $collaborators_row["projectrole"]).")</div>";
					}
				}

			?>



			<h2 class="outfont">Publications</h2>

			<?php
				foreach ($project["publication"] as $publication_id) {
					error_log("pub id:".$publication_id);
					$publication = WPRI_Database::get_record("publication",$publication_id) ;
                    echo "<a class='list-group-item' href='".site_url()."/publication?id=".$publication_id."'>".$publication["title"]."</a>";
				}
			?>

</div><!-- #project -->








	<!--
	<h2 class="member">News:</h2>
	Needs work. From project management connect a wpri_news post with the project to query from here.
	-->
