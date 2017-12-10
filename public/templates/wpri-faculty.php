<div class='listing' id="faculty" >
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

    echo "<h1 class='single'>Faculty</h1>";
    $member = $members[$director];
    echo "<div class='row'>
            <a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-8 offset-xs-2 single'>
                    <div class='col-xs-12 single'><h2 class='single'>".$member["title"]." ".$member['name']."</h2></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'><h3 class='single'>".$member['position']."</h3></div>
                </div>
            </a>
            </div>
        <hr/>";

    $member = $members[$vicedirector];
    echo "<div class='row'>
            <a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-8 offset-xs-2 single'>
                    <div class='col-xs-12 single'><h2 class='single'>".$member["title"]." ".$member['name']."</h2></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'><h3 class='single'>".$member['position']."</h3></div>
                </div>
            </a>
        </div>
        <hr/>";
    foreach ( $faculty as $member_id ) {
        $member = $members[$member_id];
		echo "<div class='row'>
        <a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-8 offset-xs-2 single'>
                    <div class='col-xs-12 single'><h2 class='single'>".$member["title"]." ".$member['name']."</h2></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'><h3 class='single'>".$member['position']."</h3></div>
                </div>
            </a>
            </div>
            <hr/>";
	}

    echo "<h1 class='single'>Assistants</h1>";
    foreach ( $assistants as $member_id ) {
        $member = $members[$member_id];
        echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-12 single'>
                    <div class='col-xs-12 single'><h2 class='single'>".$member["title"]." ".$member['name']."</h2></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
	}

    echo "<h1 class='single'>Administrative personel</h1>";
    foreach ( $administrative as $member_id ) {
        $member = $members[$member_id];
        echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-12 single'>
                    <div class='col-xs-12 single'><h2 class='single'>".$member["title"]." ".$member['name']."</h2></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
	}
		?>
 </div><!-- #faculty -->
