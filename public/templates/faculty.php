<?php /**
 * Template Name: faculty
 * Template Post Type: page
 *
 * Display a list of all faculty members of the institute
 **/

/* Choose the header from the plugin */
/* instantiate in main, dont do it every time */
$template_loader = new WPRI_Template_Loader;
$template_loader->get_template_part( 'bte', 'header' );
?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div id="faculty" >
				<h1> <?php echo 'Faculty' ?> </h1>
				<?php
					$current_language = "en";
					// This has to be done using js. Cannot be written in DB for example.
					// Have a hidden element in the DOM to keep track of language.

					// Start the Loop.
					$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
					$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );
					echo "<div class='container' >";
                    $usermeta_table = $GLOBALS['wpdb']->prefix . "usermeta";
                    $user_table = $GLOBALS['wpdb']->prefix . "users";
                    $position_table = $GLOBALS['wpdb']->prefix . "wpri_position";
                    $title_table = $GLOBALS['wpdb']->prefix . "wpri_title";

    				foreach ( $members as $member ) {
                        $fname = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='first_name' AND user_id = %d", $member->user));
                        $lname = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='last_name' AND user_id = %d", $member->user));
                        $email = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT user_email FROM " . $user_table . " WHERE ID = %d", $member->user));
                        $position = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT name FROM " . $position_table ." WHERE id = %d", $member->position));
                        $titlen= $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='title' AND user_id = %d", $member->user));
                        $atitle = $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT name FROM " . $title_table ." WHERE id = %d", $titlen));

						echo "<a href='".site_url()."/member?id=".$member->user."'><div class='faculty-thumb col-md-5'>";
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
                        echo "</div></a>";
					}
					echo "</div>";
				?>
			</div><!-- #faculty -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php

get_footer('bte');
