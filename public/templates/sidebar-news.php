	<div class="wpri-sidebar">
		<h4 class="wpri-sidebar">News</h4>

		<ol class="wpri-sidebar">

			<?php
				$args = array( 'post_type' => 'wpri_news', 'posts_per_page' => 10 );
						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) : $loop->the_post();
						  the_title();
						  echo '<div>';
						  the_content();
						  echo '</div>';
						endwhile;
			?>
		</ol>
	</div>
