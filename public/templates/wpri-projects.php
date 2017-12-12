<div class='single' id="projects" >
    <h1 class="single"> Projects </h1>
        <ul class="list-group">

 			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity("project",$project_id);
                    echo "<a class='list-group-item' href='".site_url()."/project?id=".$project_id."'>";
                        echo"<div'>
                            <div><h2 class='single'>".$project['title']."</h2></div>
                            <div>".$project["picture"]."</div>
                            <div><h3 class='single'>Funded by: ".join(",",$project['agency'])."</h3></div>
                        </div>" ;
                    echo "</a>";
			}
 			?>
        </ul>
  </div><!-- #projects -->
