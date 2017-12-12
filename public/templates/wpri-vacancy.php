
<div class="single">

		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_entity("vacancy",$position_id);

		?>
		<ul class='list-group'>
			<div class='list-group-item'>

			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $position['official_title'];?></h1> </div>

			<div class='col-sm-2 col-md-2 col-lg-2 single'>Position:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['vacancytype'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Application deadline: </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['deadline'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Starting date:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['startingdate'];?> </div>
			</div>
		</ul>

		<h2 class="outfont">Job description</h2>
			<div class='col-sm-12 col-md-12 col-lg-12 single'> <?php echo $position['description'];?> </div>


 	<h2 class="outfont">Requirements</h2>

		<?php
		foreach ($position['requirement'] as $requirement) {
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$requirement."</div>";
			echo "</div>";
		}?>


	<h2 class="outfont">Contacts</h2>
	<ul class="list-group">
	<?php
		foreach ($position["member"] as $member_id) {
			$member = WPRI_Database::get_record("member",$member_id) ;
			echo "<a class='list-group-item' href='".site_url()."/member?id=".$member["id"]."'>". $member["name"]."</a>";
		}
	?>

	<h2 class="outfont">Related Projects</h2>
	<ul class="list-group">
	<?php
		foreach ($position["project"] as $project_id) {
			$project = WPRI_Database::get_record("project",$project_id) ;
			echo "<a class='list-group-item' href='".site_url()."/project?id=".$project["id"]."'>". $project["official_title"]."</a>";
		}
	?>




</div><!-- #position -->
