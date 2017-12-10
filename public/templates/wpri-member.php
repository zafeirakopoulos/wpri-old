<div id="member" >
	<div class='row'>
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);
		?>
		<div class='row'>
	        <a href='<?php echo site_url()."/member?id=".$member["id"];?>' class=''>
                <div class='col-xs-8 offset-xs-2 '>
                    <div class='col-xs-12 '><h1><?php echo $member["title"]." ".$member['name'];?></h1></div>
                    <div class='col-xs-3 '><?php echo get_avatar($member['user']);?></div>
                    <div class='col-xs-9 '><h3><?php echo $member['position'];?></h3></div>
                </div>
            </a>
        </div>
	</div>

	<h1> Contact </h1>
	<div class='row'>
		<div class='col-xs-12 col-sm-4 '>
				<h3>Office</h3> <br>
				<h3><?php echo $member['office'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 '>
				<h3>Phone</h3> <br>
				<h3><?php echo $member['phone'];?></h3>
		</div>
		<div class='col-xs-12 col-sm-4 '>
				<h3>email</h3> <br>
				<h3><?php echo $member['email'];?></h3>
		</div>
	</div>

	<h1> Publications </h1>
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

	<h1> Projects </h1>
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

		<h1> Education </h1>
			<ul class="list-group">
				<li class="list-group-item"> <?php echo $member["undergrad"]["year"].": ".$member["undergrad"]["title"]." from ".$member["undergrad"]["university"]." (".$member["undergrad"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["masters"]["year"].": ".$member["masters"]["title"]." from ".$member["masters"]["university"]." (".$member["masters"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["phd"]["year"].": ".$member["phd"]["title"]." from ".$member["phd"]["university"]." (".$member["phd"]["program"].")"?>

			</ul>

	<h1> Posts </h1>

	<?php $args = array(
	      'author__in'     => array($member['user']),
	      'posts_per_page' => 20,
	      'post_type' => 'wpri_blog'
	    );

	    $loop = new WP_Query( $args );

	    while ( $loop->have_posts() ) : $loop->the_post();
	        echo "<div class='row'>";
	            echo "<a class='' href='".site_url()."/news/".$post->post_name."'>";
	                echo "<div class='col-sm-12 col-md-12 col-lg-12  '>".the_title()."</div>";
	            echo "</a>";
	        echo "</div>";

	    endwhile;
	?>
</div>
