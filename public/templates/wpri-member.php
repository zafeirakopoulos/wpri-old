<div class='single' id="member" >
	<div class='row'>
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);
		?>
		<div class='row'>
	        <a href='<?php echo site_url()."/member?id=".$member["id"];?>' class='single'>
                <div class='col-xs-8 offset-xs-2 single'>
                    <div class='col-xs-12 single'><h1 class='single'><?php echo $member["title"]." ".$member['name'];?></h1></div>
                    <div class='col-xs-3 single'><?php echo get_avatar($member['user']);?></div>
                    <div class='col-xs-9 single'><?php echo $member['position'];?></div>
                </div>
            </a>
        </div>
	</div>
	<hr/>

	<h1> Contact </h1>
	<div class='row'>
		<div class='col-xs-12 col-sm-4 single'>
			<p>
				Office <br>
				<?php echo $member['office'];?>
			</p>
		</div>
		<div class='col-xs-12 col-sm-4 single'>
			<p>
				Phone <br>
				<?php echo $member['phone'];?>
			</p>
		</div>
		<div class='col-xs-12 col-sm-4 single'>
			<p>
				email <br>
				<?php echo $member['email'];?>
			</p>
		</div>
	</div>
	<hr/>

	<h1> Publications </h1>
	<ul class="list-group">
		<?php
		foreach ($member["publication"] as $publication_id) {
			$publication = WPRI_Database::get_record("publication",$publication_id) ;
			echo "<a class='list-group-item single' href='".site_url()."/publication?id=".$publication_id."'>";
			echo $publication["title"];
			echo "</a>";
		}
		?>
	</ul>
	<hr/>

	<h1> Projects </h1>
		<ul class="list-group">
		<?php
		foreach ($member["project"] as $proj) {
			$project = WPRI_Database::get_record("project",$proj[0]) ;
			echo "<a class='list-group-item single' href='".site_url()."/project?id=".$proj[0]."'>";
 			echo $project["official_title"]." (".$proj[1].")";
			echo "</a>";
		}
		?>
		</ul>
	<hr/>

		<h1> Education </h1>
			<ul class="list-group">
				<li class="list-group-item"> <?php echo $member["undergrad"]["year"].": ".$member["undergrad"]["title"]." from ".$member["undergrad"]["university"]." (".$member["undergrad"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["masters"]["year"].": ".$member["masters"]["title"]." from ".$member["masters"]["university"]." (".$member["masters"]["program"].")"?>
				<li class="list-group-item"> <?php echo $member["phd"]["year"].": ".$member["phd"]["title"]." from ".$member["phd"]["university"]." (".$member["phd"]["program"].")"?>

			</ul>
		<hr/>

	<h1> Posts </h1>

	<?php $args = array(
	      'author__in'     => array($member['user']),
	      'posts_per_page' => 20,
	      'post_type' => 'wpri_blog'
	    );

	    $loop = new WP_Query( $args );

	    while ( $loop->have_posts() ) : $loop->the_post();
	        echo "<div class='row'>";
	            echo "<a class='single' href='".site_url()."/news/".$post->post_name."'>";
	                echo "<div class='col-sm-12 col-md-12 col-lg-12  single'>".the_title()."</div>";
	            echo "</a>";
	        echo "</div>";

	    endwhile;
	?>
</div>
