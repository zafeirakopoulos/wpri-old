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
				$members = $GLOBALS['wpdb']->get_results("SELECT * FROM " . $member_table_name );
				foreach ( $members as $member ) {
					echo '<option value='.$member->id.'>'.$member->username.'</option>';
				}
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
 
get_footer();
