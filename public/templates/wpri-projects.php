<div class='single' id="projects" >
    <h1 class="outfont"> <?php _e("Projects","wpri") ?> </h1>
        <ul class="list-group">

 			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity_raw("project",$project_id);
                if (in_array($project["status"], array(1,3,4))) {
                    echo "<a class='row list-group-item' href='".site_url()."/project?id=".$project_id."'>";
                        echo "<img class='col-xs-2'  src='".$project["picture"]."'>";
                        echo "<div class='col-xs-10  row  list-item'>";
                            echo "<h2 class=' list-item'>".$project['title']."</h2>";
                            $agency_array = array();
                            foreach ($project['agency'] as $agency) {
                                $agency_array[] = WPRI_Database::get_localized("agency",$agency);
                            }
                            echo "<h3 class='list-item'>".__("Funded by","wpri").": ".join(",",$agency_array)."</h3>";
                        echo "</div>";
                    echo "</a> ";
                    echo " <hr/>";
                }


			}
 			?>
        </ul>
  </div><!-- #projects -->
