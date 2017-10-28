<div class="col-sm-2">
	<div class="sidebar-module">
		<h4>News</h4>
		hhheye
		<ol class="list-unstyled">

			<?php
				$args = array( 'post_type' => 'news', 'posts_per_page' => 10 );
						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) : $loop->the_post();
						  the_title();
						  echo '<div class="entry-content">';
						  the_content();
						  echo '</div>';
						endwhile;
			?>
		</ol>
	</div>
</div><!-- /.blog-sidebar -->
