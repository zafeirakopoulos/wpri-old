<?php
$template_loader = new WPRI_Template_Loader;
$template_loader->get_template_part( 'wpri', 'header' );
?>
<!-- <div class="container" style="background-image: url('http://bte.gtu.edu.tr/wp-content/uploads/2016/03/bg2.jpg'); "> -->
<div class="container">
    <div class="row" width="100%">
        <div class="col-sm-12 col-lg-10">
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
            if ( is_page( 'contact' ) ) {
                $template_loader->get_template_part( 'wpri', 'contact' );
            }
            if ( is_page( 'positions' ) ) {
                $template_loader->get_template_part( 'wpri', 'positions' );
            }
            if ( is_page( 'publications' ) ) {
                $template_loader->get_template_part( 'wpri', 'publications' );
            }
            if ( is_page( 'publication' ) ) {
                $template_loader->get_template_part( 'wpri', 'publication' );
            }

            /* For the blogs
                if ( have_posts() ) : while ( have_posts() ) : the_post();

                    get_template_part( 'content', get_post_format() );

                endwhile; endif;
            */
            ?>
        </div> <!-- /.col -->
        <div class="col-sm-12 col-lg-2">
            <?php
                $template_loader->get_template_part( 'sidebar', 'news' );
            ?>
        </div> <!-- /.col -->

    </div> <!-- /.row -->
</div> <!-- /.container -->

<?php
$template_loader->get_template_part( 'wpri', 'footer' );
?>
