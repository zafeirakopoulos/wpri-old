
<div class=" single-frame">

		<?php
		$position_id=$_GET['id'];
		$position = WPRI_Database::get_entity("vacancy",$position_id);

		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $position['official_title'];?></h1> </div>
		</div>
		<div class='row'>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Position:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['vacancytype'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Application deadline: </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['deadline'];?> </div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'>Starting date:</div>
			<div class='col-sm-2 col-md-2 col-lg-2 single'> <?php echo $position['startingdate'];?> </div>

		</div>
		<h2 class=" single">Job description</h2>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12 single'> <?php echo $position['description'];?> </div>
		</div>


 	<h2 class=" single">Requirements:</h2>

		<?php
		foreach ($position['requirement'] as $requirement) {
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".$requirement."</div>";
			echo "</div>";
		}?>


	<h2 class=" single">Contacts:</h2>
	<ul class="list-group">
	<?php
		foreach ($position["members"] as $member_id) {
			$member = WPRI_Database::get_record("member",$member_id) ;
			echo "<a class='list-group-item' href='".site_url()."/member?id=".$member["id"]."'>". $member["name"]."</a>";
		}
	?>




</div><!-- #position -->
