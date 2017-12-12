<div class="single" id="member" >
	<!-- <div class='row'> -->
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);
		?>
		<!-- <div class='row'> -->
		<ul class="list-group">

	        <a href='<?php echo site_url()."/member?id=".$member["id"];?>' class=''>
                <div class='col-xs-12  list-group-item '>
                    <div class='col-xs-12'><h1 class='list-item'  ><?php echo $member["title"]." ".$member['name'];?></h1></div>
                    <div class='col-xs-3 '><?php echo get_avatar($member['user']);?></div>
                    <div class='col-xs-9 '><h3 class="single"><?php echo $member['position'];?></h3></div>
                </div>
            </a>
		</ul>

        <!-- </div> -->
	<!-- </div> -->
	<ul class="list-group">

	<h1 class="outfont"> Contact </h1>
 		<div class='col-xs-12 col-sm-4 list-group-item'>
				<h3 class="single">Office</h3> <br>
				<h3 class="single"><?php echo $member['office'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 list-group-item'>
				<h3 class="single">Phone</h3> <br>
				<h3 class="single"><?php echo $member['phone'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 list-group-item'>
				<h3 class="single">email</h3> <br>
				<h3 class="single"><?php echo $member['email'];?></h3>
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
