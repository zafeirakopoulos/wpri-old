<div class='single' id="project" >
 			<?php

			$project_id=$_GET['id'];
			$project = WPRI_Database::get_entity("project",$project_id);

            echo "<img class='col-xs-3'  src='".$project["picture"]."'>";
            echo "<div class='col-xs-9  row  list-item'>";
                echo "<h2 class='col-xs-12 list-item'>".$project['title']."</h2><br>";
                echo "<div class='col-xs-12'><h3 class='list-item'>".__("Funded by","wpri").": ".join(",",$project['agency'])."</h3> </div>";
                echo "<div class='col-xs-12'><h3 class='list-item'>".__("Budget","wpri").": ".$project['budget']."</h3> </div>";
    			echo "<div class='col-xs-12'><h3 class='list-item'>".__("Status","wpri").": ".$project['status']."</h3> </div>";
    			if (isset($project['website']) AND $project['website']!=""){
    				echo "<div class='col-xs-12 single'><h3 class='list-item'>".$project['website']."</h3></div>";
    			}

    			echo "<div class='col-xs-12 single'><h3 class='list-item'> ".__("Activity Period","wpri").": ".
    				mysql2date( 'F j, Y', $project['startdate'] )
    				."-".
    				mysql2date( 'F j, Y', $project['enddate'] )
    				."</h3> </div>";


            echo "</div>";
 			?>

			<h2 class="outfont">" <?php _e("Participants","wpri") ?></h2>
			<h3 class="outfont"><?php _e("Institute members","wpri") ?>Institute members</h3>
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



			<h2 class="outfont"><?php _e("Publications","wpri") ?></h2>

			<?php
				foreach ($project["publication"] as $publication_id) {
 					$publication = WPRI_Database::get_record("publication",$publication_id) ;
                    echo "<a class='list-group-item' href='".site_url()."/publication?id=".$publication_id."'>".$publication["title"]."</a>";
				}
			?>

            <h2 class="outfont"><?php _e("Open Positions","wpri") ?></h2>

			<?php
				foreach ($project["vacancy"] as $vacancy_id) {
 					$vacancy = WPRI_Database::get_record("vacancy",$vacancy_id) ;
                    echo "<a class='list-group-item' href='".site_url()."/position?id=".$vacancy_id."'>".$vacancy["official_title"]."</a>";
				}
			?>


            <br><br>
</div><!-- #project -->
