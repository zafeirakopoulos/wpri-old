<div class="single" id="member" >
	<!-- <div class='row'> -->
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);
		echo "<h2 class='col-xs-12 list-item'>". $member["title"]." ".$member['name']."</h2><br>";

		echo "<div class='col-xs-2'>". get_avatar($member['user']) ."</div>";
		echo "<div class='col-xs-10  row  list-item'>";
			echo "<div class='col-xs-12'><h3 class='list-item'>".$member['position']."</h3> </div>";

			echo "<div class='col-xs-12'><h3 class='list-item'> Office: ".$member['office']."</h3> </div>";
			echo "<div class='col-xs-12'><h3 class='list-item'> Phone: ".$member['phone']."</h3> </div>";
			echo "<div class='col-xs-12'><h3 class='list-item'> Email: ".$member['email']."</h3> </div>";

		echo "</div>";

		?>

		<br>
        <!-- </div> -->
	<!-- </div> -->



	<h1 class="outfont"><?php _e("Posts","wpri") ?>  </h1>

	<?php $args = array(
	      'author__in'     => array($member['user']),
	      'posts_per_page' => 20,
	      'post_type' => 'wpri_blog'
	    );

	    $loop = new WP_Query( $args );
		echo "<ul class='list-group'>";

	    while ( $loop->have_posts() ) : $loop->the_post();
			echo "<a class='list-group-item' href='".site_url()."/blog/".$post->post_name."/?member=".$member_id."'>".get_the_title()."</a>";
	    endwhile;
		echo "</ul>";

		?>

	<h1 class="outfont"> <?php _e("Publications","wpri") ?>  </h1>
	<ul class="list-group ">
		<?php
		foreach ($member["publication"] as $publication_id) {
			$publication = WPRI_Database::get_record("publication",$publication_id) ;
			echo "<a class='list-group-item' href='".site_url()."/publication?id=".$publication_id."'>";
			echo $publication["title"];
			echo "</a>";
		}
		?>
	</ul>

	<h1 class="outfont"> <?php _e("Projects","wpri") ?> </h1>
		<ul class="list-group">
		<?php
		foreach ($member["project"] as $proj) {
			$project = WPRI_Database::get_record("project",$proj[0]) ;
			echo "<a class='list-group-item' href='".site_url()."/project?id=".$proj[0]."'>";
 			echo $project["official_title"]." (".$proj[1].")";
			echo "</a>";
		}
		?>
		</ul>

		<h1 class="outfont"> <?php _e("Education","wpri") ?> </h1>
			<ul class="list-group">
				<?php
					if ($member["undergrad"]["year"]!=""){
					  echo "<li class='list-group-item'>" .$member["undergrad"]["year"].": ".$member["undergrad"]["title"]." from ".$member["undergrad"]["university"]." (".$member["undergrad"]["program"].")";
					}
					if ($member["masters"]["year"]!=""){
						echo "<li class='list-group-item'>" .$member["masters"]["year"].": ".$member["masters"]["title"]." from ".$member["masters"]["university"]." (".$member["masters"]["program"].")";
					}
					if ($member["phd"]["year"]!=""){
						echo "<li class='list-group-item'>" .$member["phd"]["year"].": ".$member["phd"]["title"]." from ".$member["phd"]["university"]." (".$member["phd"]["program"].")";
					}
 				?>
			</ul>



</div>
