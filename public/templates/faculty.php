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
			<div id="faculty" >
				<h1> <?php echo 'Faculty' ?> </h1>
				<?php
					$current_language = "en";
					// This has to be done using js. Cannot be written in DB for example.
					// Have a hidden element in the DOM to keep track of language.

					// Start the Loop.
					$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
					$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );
					echo "<div class='faculty' >";
  	    			echo "<ul class='faculty'>";
                    $usermeta_table = $GLOBALS['wpdb']->prefix . "usermeta";

    				foreach ( $members as $member ) {
                        $all_entries = $GLOBALS['wpdb']->get_results(
                            $GLOBALS['wpdb']->prepare(
                                "SELECT meta_value FROM " . $usermeta_table . " WHERE meta_key='first_name' AND user_id = %d", $member->id
                            ));
                            echo $all_entries[0]->first_name;

	                    echo "<li class='faculty' style='border-radius: 25px;border: 2px solid #73AD21; padding: 20px;'>";
                        echo "<table>";
                        echo "<tr><h3 class='faculty'><?php $member->id.'>'.$member->username ?></h3></tr>";
                        echo "<tr><td>";
                        echo get_avatar( $member->user );
                        echo "</td>";
                        echo "<td><p class='faculty'>Lorem ipsum dolor sit amet...</p></td></tr>";
                        echo "</table>";
                        echo "</li>";
					}
  	    			echo "</ul>";
					echo "</div>";
				?>
			</div><!-- #faculty -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php

get_footer();
