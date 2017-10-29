
<div class="member">
	<div class="container">
		<?php
		$publication_id=$_GET['id'];
		$publication = WPRI_Database::get_publication_full($publication_id);
		?>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12'><h1> <?php echo $publication['title'];?></h1> </div>
		</div>
		<div class='row'>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo "publication picture"?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $publication['doi'];?> </div>
			<div class='col-sm-3 col-md-3 col-lg-3'> <?php echo $publication["pubtype"];?> </div>
		</div>
		<div class='row'>
			<div class='col-sm-12 col-md-12 col-lg-12'> <?php echo $publication['bibentry'];?> </div>
		</div>
	</div>



	<h2 class="member">Authors:</h2>
	<div class="container">
	<?php
		foreach ($publication['authors'] as $author) {
			$member = WPRI_Database::get_member($author->member);
			echo "<a class='member' href='".site_url()."/member?id=".$author->member."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".$member['name']."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>

	<h2 class="member">Projects:</h2>
	<div class="container">
		<?php
		foreach ($publication['projects'] as $project_row) {
			$project = WPRI_Database::get_project($project_row->project);
			echo "<a class='member' href='".site_url()."/project?id=".$project_row->project."'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12 col-md-12 col-lg-12'>".$project->title."</div>";
			echo "</div>";
			echo "</a>";
		}?>
	</div>


</div><!-- #publication -->
