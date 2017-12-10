<div class='single' id="member" >
 		<div class='row'>
			<?php

			$member_id=$_GET['id'];
			$member = WPRI_Database::get_member_full($member_id);

 			echo "<div class='row'>
	        <a href='".site_url()."/member?id=".$member["id"]."' class='single'>
	                <div class='col-xs-8 offset-xs-2 single'>
	                    <div class='col-xs-12 single'><h1 class='single'>".$member["title"]." ".$member['name']."</h1></div>
	                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
	                    <div class='col-xs-9 single'>".$member['position']."</div>
	                </div>
	            </a>
	            </div>
	          <hr/>";
		?>
			<hr/>
			<h1> Education </h1>
				<ul>
				</ul>

	</div>
</div>
