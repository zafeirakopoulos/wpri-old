<div class='single' id="faculty" >
	<?php
	$members= WPRI_Database::get_all("member");
    $faculty = array();
    $assistants = array();
    $administrative = array();
    $director = 0;
    $vicedirector=0;
    foreach ( $members as $member ) {
        if (get_user_meta($member["user"],"position",true)==1) {
            $director  = $member["id"];
        }
        if (get_user_meta($member["user"],"position",true)==2) {
            $vicedirector  = $member["id"];
        }
        if (in_array(get_user_meta($member["user"],"position",true),array(3))){
            $faculty[] = $member["id"];
        }
        if (in_array(get_user_meta($member["user"],"position",true),array(4,5))){
            echo $member["id"];
            $assistants[] = $member["id"];
        }
        if (in_array(get_user_meta($member["user"],"position",true),array(6))){
            $administrative[] = $member["id"];
        }
    }

    $members = WPRI_Database::get_members_full();

     echo "<h1 class='outfont'>". __("Faculty","wpri")."</h1>";
	echo "<ul class='list-group'>";

	    $member = $members[$director];
		echo "<a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item'>
				<h2 class='list-item'>".$member["title"]." ".$member['name']."</h2>".get_avatar($member['user']).$member['position']."
			</a>";

	    $member = $members[$vicedirector];
		echo "<a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item'>
				<h2 class='list-item'>".$member["title"]." ".$member['name']."</h2>".get_avatar($member['user']).$member['position']."
			</a>";

	    foreach ( $faculty as $member_id ) {
	        $member = $members[$member_id];
		        echo "<a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item'>
		                <h2 class='list-item'>".$member["title"]." ".$member['name']."</h2>".get_avatar($member['user']).$member['position']."
		            </a>";
		}
	echo "</ul>";


    echo "<h1 class='outfont'>". __("Assistants","wpri")."</h1>";
	echo "<ul class='list-group'>";
    foreach ( $assistants as $member_id ) {
		$member = $members[$member_id];
			echo "<a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item'>
					<h2 class='list-item'>".$member["title"]." ".$member['name']."</h2>".get_avatar($member['user']).$member['position']."
				</a>";
	}
	echo "</ul>";

    echo "<h1 class='outfont'>". __("Administrative personel","wpri")."</h1>";
	echo "<ul class='list-group'>";

    foreach ( $administrative as $member_id ) {
		$member = $members[$member_id];
			echo "<a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item'>
					<h2 class='list-item'>".$member["title"]." ".$member['name']."</h2>".get_avatar($member['user']).$member['position']."
				</a>";
	}
	echo "</ul>";

		?>
 </div><!-- #faculty -->
