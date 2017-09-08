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
				<h1> <?php Faculty ?> </h1>
				<?php
					$current_language = "en" 
					// This has to be done using js. Cannot be written in DB for example.
					// Have a hidden element in the DOM to keep track of language.

					// Start the Loop.
					$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
					$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );		
					foreach ( $members as $member ) {
					

						echo $member->id.'>'.$member->username.'<br>';
					}
				?>
			</div><!-- #faculty -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
 
get_footer();
