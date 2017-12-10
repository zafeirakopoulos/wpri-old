<div class='listing' id="projects" >
 			<?php
			$project_ids= WPRI_Database::get_ids("project");
 			foreach ( $project_ids as $project_id ) {
				$project = WPRI_Database::get_entity("project",$project_id);

                echo "<div class='row'>
                        <a href='".site_url()."/project?id=".$project_id."' class='single'>
                            <div class='col-xs-8 offset-xs-2 single'>
                                <div class='col-xs-12 single'><h1 class='single'>".$project['title']."</h1></div>
                                <div class='col-xs-3 single'>".$project["picture"]."</div>
                                <div class='col-xs-9 single'><h3 class='single'>Funded by: ".join(",",$project['agency'])."</h3></div>
                            </div>
                        </a>
                        </div>
                    <hr/>";
			}
 			?>
  </div><!-- #projects -->
