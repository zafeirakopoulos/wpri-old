<div class="wpri-sidebar">
	<h4 class="wpri-sidebar">News</h4>
	<ol class="wpri-sidebar">
		<?php
			$args = array( 'post_type' => 'wpri_news', 'posts_per_page' => 10 );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
				echo "<a class='faculty-thumb-link' href='".site_url()."/news/".$post->post_name."'>";
					echo '<div>';
					the_title();

					the_content();
	  				echo '</div>';
				echo "</a>";
			endwhile;
		?>
	</ol>
</div>
