
<div class="member">
	<div class="container">
		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_open_position($position_id);
		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12'><h1> <?php echo $position['title'];?></h1> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3'>Position:</div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $position['postype'];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3'>Application deadline: </div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $position['deadline'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3'>Starting date:</div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $position['startdate'];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3'>Ending date: </div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $position['enddate'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12'> <?php echo $position['description'];?> </div>
		</div>
	</div>
<!--
	<h2 class="member">Requirements:</h2>
	<div class="container">
		<?php
		$member_publications = WPRI_Database::get_member_publications($member_id);
		foreach ($member_publications as $publication) {
			$pub = WPRI_Database::get_publication($publication->pub);
			echo "<a class='member' href='".site_url()."/publication?id=".$pub->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".$pub->title."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>

	<h2 class="member">Contacts:</h2>
	<div class="container">
		<?php
		foreach ($position['enddate']['contacts']] as $contact) {
			$member = WPRI_Database::get_member_short($contact->member);
			echo "<a class='member' href='".site_url()."/publication?id=".$contact->member."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".$member['name']."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>

	<h2 class="member">Projects:</h2>
	<div class="container">
		<?php foreach ($member['projects'] as $project_member) {
			$project = WPRI_Database::get_project( $project_member->project);
			echo "<a class='member' href='".site_url()."/project?id=".$project->id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4 col-md-4 col-lg-4'>".$project->title."</div>";
				echo "<div class='col-sm-2 col-md-2 col-lg-2'>". WPRI_Database::get_project_role($project_member->role)."</div>";
				echo "<div class='col-sm-2 col-md-2 col-lg-2'>".$project->PI."</div>";
				echo "<div class='col-sm-2 col-md-2 col-lg-2'>".$project->funding."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div> -->


</div><!-- #position -->
