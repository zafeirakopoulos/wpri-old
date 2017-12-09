<div class='listing' id="faculty" >
	<?php
	$members= WPRI_Database::get_all("member");
    $faculty = array();
    $assistants = array();
    $administrative = array();
    foreach ( $members as $member ) {
        if (in_array($member["position"],array(1,2,3))){
            $faculty[] = $member["id"];
        }
        if (in_array($member["position"],array(4,5))){
            $assistants[] = $member["id"];
        }
        if (in_array($member["position"],array(6))){
            $administrative[] = $member["id"];
        }
    }

    $members = WPRI_Database::get_members_full();
    echo "<h1>Faculty</h1>";

    echo "<div class='list-group'>";

    foreach ( $faculty as $member_id ) {
        $member = $members[$member_id];
		echo "  <a href='".site_url()."/member?id=".$member["id"]."' class='list-group-item list-group-item-action flex-column align-items-start '>
            <div class='d-flex flex-row'>";

            echo "<div class='p-9'> <h2>".$member["title"]." ".$member['name']."</h2></div><div class='p-2'>".get_avatar($member['user'])."</div>";
			echo "</div></a>";
            //
			// 	echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['position']."</div>";
			// 	if (isset($member['website']) AND $member['website']!=""){
			// 		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['website']."</div>";
			// 	}
			// 	else{
			// 		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
			// 		echo "<a class='listing-thumb' href='".site_url()."/member?id=".$member_id."'>".site_url()."/member?id=".$member_id."</a>";
			// 		echo "</div>";
			// 	}
			// 	echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['email']."</div>";
	}

    echo "<h1>Assistants</h1>";
    foreach ( $assistants as $member_id ) {
        $member = $members[$member_id];
		echo "<div class='col-sm-12 listing-thumb-frame'>";
			echo "<a class='listing-thumb' href='".site_url()."/member?id=".$member["id"]."'>";
				echo "<div class='col-xs-12 col-md-6 col-ld-12  listing-thumb'>".get_avatar($member['user'])."</div>";
			// echo "<div class='row'>";
			echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'><h1 class='listing'>".$member["title"]." ".$member['name']."</h1> </div>";
			echo "</div>";
			echo "</a>";
            //
			// 	echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['position']."</div>";
			// 	if (isset($member['website']) AND $member['website']!=""){
			// 		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['website']."</div>";
			// 	}
			// 	else{
			// 		echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>";
			// 		echo "<a class='listing-thumb' href='".site_url()."/member?id=".$member_id."'>".site_url()."/member?id=".$member_id."</a>";
			// 		echo "</div>";
			// 	}
			// 	echo "<div class='col-xs-12 col-md-6 col-ld-12 listing-thumb'>".$member['email']."</div>";
			echo "</div>";

		echo "</div>";
	}
    echo "<h1>Administrative personel</h1>";

		?>
 </div><!-- #faculty -->
