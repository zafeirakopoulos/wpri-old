
<div class=" single-frame">
	<div class="row">
		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_open_position($position_id);
		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $position['title'];?></h1> </div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Position:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['postype'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Application deadline: </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['deadline'];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Starting date:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['startdate'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Ending date: </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['enddate'];?> </div>
		</div>
		<h2 class=" single">Job description</h2>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'> <?php echo $position['description'];?> </div>
		</div>
	</div>

 	<h2 class=" single">Requirements:</h2>
	<div class="container">
		<?php
		foreach ($position['requirements'] as $requirement) {
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".WPRI_Database::get_requirement($requirement->requirement)."</div>";
			echo "</div>";
		}?>
	</div>

	<h2 class=" single">Contacts:</h2>
	<div class="container">
		<?php
		foreach ($position['contacts'] as $contact) {
			$member = WPRI_Database::get_member_short($contact->member);
			echo "<a class=' single' href='".site_url()."/publication?id=".$contact->member."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$member['name']."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>

	<h2 class=" single">Projects:</h2>
	<div class="container">
		<?php
		foreach ($position['projects'] as $project) {
			echo "<a class=' single' href='".site_url()."/project?id=".$project->project."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".WPRI_Database::get_project_short($project->project)['title']."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>


</div><!-- #position -->
