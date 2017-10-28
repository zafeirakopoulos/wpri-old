	<div class="sidebar">
		<h4>News</h4>
		hhheye
		<ol >

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
