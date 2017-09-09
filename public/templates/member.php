<?php /**
 * Template Name: faculty
 * Template Post Type: page
 *
 * Display a list of all faculty members of the institute
 **/


get_header('bte'); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div id="member" >
				<?php
					$current_language = "en";

					$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
					$usermeta_table = $GLOBALS['wpdb']->prefix . "usermeta";
					$user_table = $GLOBALS['wpdb']->prefix . "users";
					$position_table = $GLOBALS['wpdb']->prefix . "wpri_position";
					$title_table = $GLOBALS['wpdb']->prefix . "wpri_title";

					$member_id=$_GET['id'];
					$member = $GLOBALS['wpdb']->get_row($GLOBALS['wpdb']->prepare("SELECT * FROM " . $member_table_name . " WHERE id = %d", $member_id));
					$user_id = $member->user;
					$user = $GLOBALS['wpdb']->get_row($GLOBALS['wpdb']->prepare("SELECT * FROM " . $user_table . " WHERE ID = %d", $user_id));
					$usermeta = $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare("SELECT * FROM " . $usermeta_table . " WHERE user_id = %d", $user_id));
					echo $member_id;
					echo "<br>";
					echo $user_id;
					echo "<br>";
					echo $usermeta[last_name];
					echo "<br>";

					$fname = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='first_name' AND user_id = %d", $member->user));
					$lname = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='last_name' AND user_id = %d", $member->user));
					$email = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT user_email FROM " . $user_table . " WHERE ID = %d", $member->user));
					$position = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT name FROM " . $position_table ." WHERE id = %d", $member->position));
					$titlen= $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='title' AND user_id = %d", $member->user));
					$atitle = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT name FROM " . $title_table ." WHERE id = %d", $titlen));

					echo "<table>";
					echo "<tr><h3 class='faculty'>";
					echo $atitle." ".$fname." ".$lname;
					echo "</h3></tr>";
					echo "<tr><td>";
					echo get_avatar( $member->user );
					echo "</td>";
					echo "<td><p>";
					echo $position."<br>";
					echo $member->website."<br>";
					echo $email."<br>";
					echo "</p></td></tr>";
					echo "</table>";
				?>

				<h1> <?php echo 'Faculty' ?> </h1>

			</div><!-- #faculty -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php

get_footer('bte');
