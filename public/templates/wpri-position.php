
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
			<div class='col-sm-2 col-md-2 col-lg-2'>Position:</div>
			<div class='col-sm-2 col-md-2 col-lg-2'> <?php echo $position['postype'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2'>Application deadline: </div>
			<div class='col-sm-2 col-md-2 col-lg-2'> <?php echo $position['deadline'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-md-2 col-lg-2'>Starting date:</div>
			<div class='col-sm-2 col-md-2 col-lg-2'> <?php echo $position['startdate'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2'>Ending date: </div>
			<div class='col-sm-2 col-md-2 col-lg-2'> <?php echo $position['enddate'];?> </div>
		</div>
		<h2>Job description</h2>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12'> <?php echo $position['description'];?> </div>
		</div>
	</div>

 	<h2 class="member">Requirements:</h2>
	<div class="container">
		<?php
		foreach ($position['requirements'] as $requirement) {
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".WPRI_Database::get_requirement($requirement->requirement)."</div>";
			echo "</div>";
		}?>
	</div>

	<h2 class="member">Contacts:</h2>
	<div class="container">
		<?php
		foreach ($position['contacts'] as $contact) {
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
		<?php
		foreach ($position['projects'] as $project) {
			echo "<a class='member' href='".site_url()."/project?id=".$project->project."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".WPRI_Database::get_project_short($project->project)['title']."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>


</div><!-- #position -->
