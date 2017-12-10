<div class='single' id="member" >
	<div class='row'>
		<?php
		$member_id=$_GET['id'];
		$member = WPRI_Database::get_member_full($member_id);
		?>
			<div class='row'>
	        <a href='<?php echo site_url()."/member?id=".$member["id"];?>' class='single'>
                <div class='col-xs-8 offset-xs-2 single'>
                    <div class='col-xs-12 single'><h1 class='single'><?php echo $member["title"]." ".$member['name'];?></h1></div>
                    <div class='col-xs-3 single'><?php echo get_avatar($member['user']);?></div>
                    <div class='col-xs-9 single'><?php echo $member['position'];?></div>
                </div>
            </a>
        </div>
        <hr/>

		<h1> Contact </h1>
			<div class='row'>
				<div class='col-sm-12 col-ld-4 single'>
					<p>
						Office <br>
						<?php echo $member['office'];?>
					</p>
				</div>
				<div class='col-sm-12 col-ld-4 single'>
					<p>
						Phone <br>
						<?php echo $member['phone'];?>
					</p>
				</div>
				<div class='col-sm-12 col-ld-4 single'>
					<p>
						email <br>
						<?php echo $member['email'];?>
					</p>
				</div>
			</div>
		<hr/>

		<h1> Education </h1>
			<ul>
			</ul>
		<hr/>


		<h1> Education </h1>
			<ul>
			</ul>
		<hr/>

	</div>
</div>
