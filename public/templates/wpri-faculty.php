<div class='faculty' id="faculty" >
	<h1 class='faculty'> Faculty </h1>
	<div class='container'>
		<div class='row'>
			<?php
			// Start the Loop.
			$member_ids = WPRI_Database::get_member_ids();
			echo "<div class='row'>";
			foreach ( $member_ids as $member_id ) {
				$member = WPRI_Database::get_member_short($member_id);
				$member_id=$_GET['id'];
				$member = WPRI_Database::get_member($member_id);
				echo "<a class='faculty-thumb' href='".site_url()."/member?id=".$member_id."'>";
						echo "<div class='col-sm-12 col-md-5 col-lg-5'>";
							echo "<div class='col-sm-12 col-md-12 col-lg-12 faculty-thumb'><h1 class='faculty'>".$member['title']." ".$member['name']."</h1> </div>";
							echo "<div class='col-sm-3 col-md-3 col-lg-3 faculty-thumb'>".get_avatar( $member['user'])."</div>";
							echo "<div class='col-sm-9 col-md-9 col-lg-9 faculty-thumb'>".$member['position']."</div>";
							echo "<div class='col-sm-6 col-md-6 col-lg-6 faculty-thumb'>".$member['website']."</div>";
							echo "<div class='col-sm-6 col-md-6 col-lg-6 faculty-thumb'>".$member['email']."</div>";
						echo "</div>";
				echo "</a>";
				}
			echo "</div>";
			?>
		</div>
	</div>
</div><!-- #faculty -->
