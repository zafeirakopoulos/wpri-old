<?php
	$template_loader = new WPRI_Template_Loader;
	$template_loader->get_template_part( 'wpri', 'header' );
?>

	<div class="row">

		<div class="col-sm-8 bte-main">

			<?php get_template_part( 'content', get_post_format() ); ?>

		</div> <!-- /.blog-main -->

		<?php get_sidebar(); ?>

	</div> <!-- /.row -->

<?php
	$template_loader->get_template_part( 'wpri', 'footer' );
?>
