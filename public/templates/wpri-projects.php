<div class='single' id="projects" >
    <h1 class="single"> Projects </h1>
        <ul class="list-group">

 			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity("project",$project_id);

                // echo "<div class='row'>
                //         <a href='".site_url()."/project?id=".$project_id."' class='single'>
                //             <div class='col-xs-8 offset-xs-2 single'>
                //                 <div class='col-xs-12 single'><h2 class='single'>".$project['title']."</h2></div>
                //                 <div class='col-xs-3 single'>".$project["picture"]."</div>
                //                 <div class='col-xs-9 single'><h3 class='single'>Funded by: ".join(",",$project['agency'])."</h3></div>
                //             </div>
                //         </a>
                //         </div>
                //     <hr/>";

                    echo "<a class='list-group-item' href='".site_url()."/project?id=".$project_id."'>";
                        // echo"<div'>";
                        echo "<h2 class='single'>".$project['title']."</h2><br>";
                        echo "<h3 class='single'>Funded by: ".join(",",$project['agency'])."</h3>";
                        // echo "<div>".$project["picture"]."</div>";
                    echo "</a>";
			}
 			?>
        </ul>
  </div><!-- #projects -->
