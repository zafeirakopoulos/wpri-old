
<div class="single">
 		<?php
		$publication_id=$_GET['id'];
		$publication = WPRI_Database::get_entity("publication",$publication_id);
		?>
		<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $publication['title'];?></h1> </div>
		<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo "publication picture"?> </div>
		<div class='col-sm-12 single'> <?php echo $publication['authors'];?> </div>
		<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $publication['doi'];?> </div>
		<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo $publication["pubtype"];?> </div>
		<div class='col-sm-12 col-md-12 col-lg-12 wordwrap single'> <?php echo $publication['bibtex'];?> </div>

	<h2 class=" single">Authors</h2>
	<?php
		foreach ($publication['member'] as $member_id) {
			$member = WPRI_Database::get_record("member",$member_id) ;
			echo "<a class=' single' href='".site_url()."/member?id=".$member_id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 single'>".$member["name"]."</div>";
			echo "</div>";
			echo "</a>";
		}?>


	<h2 class=" single">Projects</h2>
	<div class="container">
		<?php
		foreach ($publication['project'] as $project_id) {
			$project = WPRI_Database::get_record("project",$project_id) ;
			echo "<a class=' single' href='".site_url()."/project?id=".$project_id."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12 single'>".
				WPRI_Database::get_localized_element("project","title",$project_id)
				."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>


</div><!-- #publication -->
