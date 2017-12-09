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


    foreach ( $faculty as $member_id ) {
        $member = $members[$member_id];
		echo "<a href='".site_url()."/member?id=".$member["id"]."' class='single'>
                <div class='col-xs-6 single'>
                    <div class='col-xs-12 single'><h1>".$member["title"]." ".$member['name']."</h1></div>
                    <div class='col-xs-3 single'>".get_avatar($member['user'])."</div>
                    <div class='col-xs-9 single'>".$member['position']."</div>
                </div>
            </a>";
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
