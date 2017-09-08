<?php /**
 * Template Name: faculty
 * Template Post Type: page
 * 
 * Template Description...
 **/
 
 
get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
				pll_current_language();

				// Start the Loop.
				$member_table_name = $GLOBALS['wpdb']->prefix . "wpri_member" ;
				$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );
				foreach ( $members as $member ) {
					echo $member->id.'>'.$member->username.'<br>';
				}
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
 
get_footer();
