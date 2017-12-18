
<div class="single">

		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_entity("vacancy",$position_id);

		?>
		<ul class='list-group'>
			<div class='col-sm-12 list-group-item-alt'>

			<div class='col-sm-12 col-md-12 col-lg-12 '><h1 class='list-item-alt'> <?php echo $position['official_title'];?></h1> </div>

			<div class='col-xs-12 col-md-4 col-lg-4 '><?php _e("Position","wpri") ?>: <?php echo $position['vacancytype'];?> </div>
			<div class='col-xs-12 col-md-4 col-lg-4 '><?php _e("Application deadline","wpri") ?>:  <?php echo $position['deadline'];?> </div>
			<div class='col-xs-12 col-md-4 col-lg-4 '><?php _e("Starting date","wpri") ?>: <?php echo $position['startingdate'];?> </div>
			</div>

		<h2 class="outfont"><?php _e("Job description","wpri") ?></h2>
		<ul class='list-group'>
			<div class='list-group-item-alt'> <?php echo $position['description'];?> </div>
		</ul>


 	<h2 class="outfont"><?php _e("Requirements","wpri") ?></h2>
	<ul class='list-group'>
		<?php
		foreach ($position['requirement'] as $requirement) {
			echo "<li class='list-group-item'>".$requirement."</li>";
		}?>
	</ul>


	<h2 class="outfont"><?php _e("Contacts","wpri") ?></h2>
	<ul class="list-group">
	<?php
		foreach ($position["member"] as $member_id) {
			$member = WPRI_Database::get_record("member",$member_id) ;
			echo "<a class='list-group-item' href='".site_url()."/member?id=".$member["id"]."'>". $member["name"]."</a>";
		}
	?>

	<h2 class="outfont"><?php _e("Related Projects","wpri") ?></h2>
	<ul class="list-group">
	<?php
		foreach ($position["project"] as $project_id) {
			$project = WPRI_Database::get_record("project",$project_id) ;
			echo "<a class='list-group-item' href='".site_url()."/project?id=".$project["id"]."'>". $project["official_title"]."</a>";
		}
	?>




</div><!-- #position -->
