<div class='listing' id="faculty" >
	<?php
	$members= WPRI_Database::get_all("member");
    $faculty = array();
    $assistants = array();
    $administrative = array();
    foreach ( $members as $member ) {
        if (in_array(get_user_meta($member["user"],"position",true),array(1,2,3))){
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
    echo "<h1>Faculty</h1>";


    foreach ( $faculty as $member_id ) {
        $member = $members[$member_id];
		echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-12 single'>
                    <div class='col-xs-12 single'><h1 class='single'>".$member["title"]." ".$member['name']."</h1></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
	}
     echo "<h1>Assistants</h1>";
    foreach ( $assistants as $member_id ) {
        $member = $members[$member_id];
        echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-12 single'>
                    <div class='col-xs-12 single'><h1 class='single'>".$member["title"]." ".$member['name']."</h1></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
	}
    echo "<h1>Administrative personel</h1>";
    foreach ( $administrative as $member_id ) {
        $member = $members[$member_id];
        echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-12 single'>
                    <div class='col-xs-12 single'><h1 class='single'>".$member["title"]." ".$member['name']."</h1></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
	}
		?>
 </div><!-- #faculty -->
