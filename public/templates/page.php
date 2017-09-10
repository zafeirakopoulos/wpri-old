<?php
$template_loader = new WPRI_Template_Loader;
$template_loader->get_template_part( 'wpri', 'header' );
?>

	<div class="row">
		<div class="col-sm-12">

			<?php

			if ( is_page( 'faculty' ) ) {
				$template_loader->get_template_part( 'wpri', 'faculty' );

			}
			if ( is_page( 'member' ) ) {
				$template_loader->get_template_part( 'wpri', 'member' );

			}
			if ( is_page( 'project' ) ) {
				$template_loader->get_template_part( 'wpri', 'project' );

			}
			if ( is_page( 'projects' ) ) {
				$template_loader->get_template_part( 'wpri', 'projects' );

			}


			/* For the blogs
				if ( have_posts() ) : while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile; endif;
			*/
			?>

		</div> <!-- /.col -->
	</div> <!-- /.row -->

<?php
$template_loader->get_template_part( 'wpri', 'footer' );
?>
