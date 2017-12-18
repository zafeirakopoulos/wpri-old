<div class="single" id="member" >
	<!-- <div class='row'> -->
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);

		echo "<div class='col-xs-3'>". get_avatar($member['user']) ."</div>";
		echo "<div class='col-xs-9  row  list-item'>";
			echo "<h2 class='col-xs-12 list-item'>". $member["title"]." ".$member['name']."</h2><br>";
			echo "<div class='col-xs-12'><h3 class='list-item'>".$member['position']."</h3> </div>";
			// echo "<div class='col-xs-12'><h3 class='list-item'>Budget: ".$project['budget']."</h3> </div>";
			// echo "<div class='col-xs-12'><h3 class='list-item'> Status: ".$project['status']."</h3> </div>";
			// if (isset($project['website']) AND $project['website']!=""){
			// 	echo "<div class='col-xs-12 single'><h3 class='list-item'>".$project['website']."</h3></div>";
			// }
            //
			// echo "<div class='col-xs-12 single'><h3 class='list-item'> Activity Period: ".
			// 	mysql2date( 'F j, Y', $project['startdate'] )
			// 	."-".
			// 	mysql2date( 'F j, Y', $project['enddate'] )
			// 	."</h3> </div>";


		echo "</div>";

		?>
		 
		<br>
        <!-- </div> -->
	<!-- </div> -->
	<ul class="list-group">

	<h1 class="outfont"> Contact </h1>
 		<div class='col-xs-12 col-sm-4 list-group-item-alt'>
				<h3 class="list-item-alt">Office</h3> <br>
				<h3 class="list-item-alt"><?php echo $member['office'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 list-group-item-alt'>
				<h3 class="list-item-alt">Phone</h3> <br>
				<h3 class="list-item-alt"><?php echo $member['phone'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 list-group-item-alt'>
				<h3 class="list-item-alt">email</h3> <br>
				<h3 class="list-item-alt"><?php echo $member['email'];?></h3>
			</p>
		</div>
	</ul>
	<h1 class="outfont"> Posts </h1>

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

	<h1 class="outfont"> Publications </h1>
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

	<h1 class="outfont"> Projects </h1>
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

		<h1 class="outfont"> Education </h1>
			<ul class="list-group">
				<li class="list-group-item"> <?php echo $member["undergrad"]["year"].": ".$member["undergrad"]["title"]." from ".$member["undergrad"]["university"]." (".$member["undergrad"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["masters"]["year"].": ".$member["masters"]["title"]." from ".$member["masters"]["university"]." (".$member["masters"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["phd"]["year"].": ".$member["phd"]["title"]." from ".$member["phd"]["university"]." (".$member["phd"]["program"].")"?>

			</ul>



</div>
