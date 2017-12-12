
<div class="single">
 		<?php
		$publication_id=$_GET['id'];
		$publication = WPRI_Database::get_entity("publication",$publication_id);
		?>
    <ul class="list-group">
        <div class=' col-xs-8   list-group-item'>
    		<div class='col-sm-12 col-md-12 col-lg-12 single'><h1 class=" single"> <?php echo $publication['title'];?></h1> </div>
    		<div class='col-sm-3 col-md-3 col-lg-3 single'> <?php echo "publication picture"?> </div>
    		<div class='col-sm-12 single'><h3 class=" single"> <?php echo $publication['authors'];?> </h3></div>
    		<div class='col-sm-3 col-md-3 col-lg-4 single'><h3 class=" single">DOI number<br> <?php echo $publication['doi'];?>  </h3></div>
    		<div class='col-sm-3 col-md-3 col-lg-4 single'><h3 class=" single">Publication type<br> <?php echo $publication["pubtype"];?> </h3> </div>
    		<div class='col-sm-12 col-md-12 col-lg-12 wordwrap single'><h3 class=" single"> <?php echo $publication['bibtex'];?>  </h3></div>
        </div>
    </ul>
	<h2 class="outfont">Authors</h2>
    <ul class="list-group">
	<?php
		foreach ($publication['member'] as $member_id) {
			$member = WPRI_Database::get_record("member",$member_id) ;
			echo "<a class='list-group-item' href='".site_url()."/member?id=".$member_id."'>".$member["name"]."</a>";
		}?>
    </ul>

	<h2 class="outfont">Projects</h2>
    <ul class="list-group">
		<?php
		foreach ($publication['project'] as $project_id) {
			$project = WPRI_Database::get_record("project",$project_id) ;
			echo "<a class='list-group-item' href='".site_url()."/project?id=".$project_id."'>".WPRI_Database::get_localized_element("project","title",$project_id)."</a>";
		}?>
    </ul>


</div><!-- #publication -->
