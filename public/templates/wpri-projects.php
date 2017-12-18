<div class='single' id="projects" >
    <h1 class="outfont"> Projects </h1>
        <ul class="list-group">

 			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity_raw("project",$project_id);
                if (in_array($project["status"], array(1,3,4))) {
                    echo "<a class='row list-group-item' href='".site_url()."/project?id=".$project_id."'>";
                        echo "<img class='col-xs-2'  src='".$project["picture"]."' width='50px'>";
                        echo "<div class='col-xs-10 list-group-item'>";
                            echo "<h2 class='list-item'>".$project['title']."</h2>";
                            echo "<h3 class='list-item'>Funded by: ".join(",",$project['agency'])."</h3>";
                        echo "</div>";
                    echo "</a> ";
                    echo " <hr/>";
                }
                // echo "<div class='row'>
                //         <a href='".site_url()."/project?id=".$project_id."' class='single'>
                //             <div class='col-xs-8 offset-xs-2 single'>
                //                 <div class='col-xs-12 single'><h2 class='single'>".$project['title']."</h2></div>
                //                 <div class='col-xs-3 single'>".$project["picture"]."</div>
                //                 <div class='col-xs-9 single'><h3 class='single'>Funded by: ".join(",",$project['agency'])."</h3></div>
                //             </div>
                //         </a>
                //         </div>
                //     ";


			}
 			?>
        </ul>
  </div><!-- #projects -->
