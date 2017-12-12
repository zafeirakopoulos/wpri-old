
<div class="single">

		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_entity("vacancy",$position_id);

		?>
		<ul class='list-group'>
			<div class='list-group-item'>

			<div class='col-sm-12 col-md-12 col-lg-12 '><h1 class=" single"> <?php echo $position['official_title'];?></h1> </div>

			<div class='col-sm-2 col-md-2 col-lg-2 '>Position:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 '> <?php echo $position['vacancytype'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 '>Application deadline: </div>
			<div class='col-sm-2 col-md-2 col-lg-2 '> <?php echo $position['deadline'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 '>Starting date:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 '> <?php echo $position['startingdate'];?> </div>
			</div>

		<h2 class="outfont">Job description</h2>
		<ul class='list-group'>
			<li class='list-group-item'> <?php echo $position['description'];?> </li>
		</ul>


 	<h2 class="outfont">Requirements</h2>
	<ul class='list-group'>
		<?php
		foreach ($position['requirement'] as $requirement) {
			echo "<li class='list-group-item'>".$requirement."</li>";
		}?>
	</ul>


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
