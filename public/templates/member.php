<?php /**
 * Template Name: faculty
 * Template Post Type: page
 *
 * Display a list of all faculty members of the institute
 **/


get_header(); ?>

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
					echo $usermeta->last_name;
					echo "<br>";
				?>

				<h1> <?php echo 'Faculty' ?> </h1>

			</div><!-- #faculty -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php

get_footer();
