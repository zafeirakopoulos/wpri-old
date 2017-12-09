
<div class="single-frame">

		<?php
		$project_id=$_GET['id'];
		$project = WPRI_Database::get_entity("project",$project_id);
		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $project['title'];?></h1> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo "project picture"?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $member['position'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $project["funding"];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3 single'> 	<?php echo $member['email'];?> </div>
		</div>



	<h2 class=" single">Participants:</h2>

	<?php
		$project_members = WPRI_Database::get_project_members($project_id);
		foreach ($project_members as $member) {
			echo "<a class=' single' href='".site_url()."/member?id=".$member->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".WPRI_Database::get_member($member->member)["name"]. "(". WPRI_Database::get_project_role($member->role).")</div>";
			echo "</div>";
			echo "</a>";
		}?>


	<h2 class=" single">Publications:</h2>

		<?php
		$project_publications = WPRI_Database::get_project_publications($project_id);
		foreach ($project_publications as $publication) {
			$pub = WPRI_Database::get_publication($publication->pub);
			echo "<a class=' single' href='".site_url()."/publication?id=".$pub->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$pub->title."</div>";
			echo "</div>";
			echo "</a>";
		}?>


	<!--
	<h2 class="member">News:</h2>
	Needs work. From project management connect a wpri_news post with the project to query from here.
	-->
</div><!-- #project -->

<!--
echo "<div class='col-sm-12 listing-thumb-frame'>";
	echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>"."picture"."</div>";
	echo "<div class='row'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$project['title']."</h1> </div>";
	echo "</div>";
	echo "</a>";

	echo "<div class='row'>";
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['status']."</div>";
		if (isset($project['website']) AND $project['website']!=""){
			echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$project['website']."</div>";
		}
		else{
			echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
			echo "<a class='listing-thumb' href='".site_url()."/project?id=".$project_id."'>".site_url()."/project?id=".$project_id."</a>";
			echo "</div>";
		}
		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>PI: ".$project['PI']."</div>";
	echo "</div>"; -->
