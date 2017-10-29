<div id="wpri-sidebar" >
	<h1 class='wpri-sidebar'> News </h1>
	<div class="wpri-sidebar">
		<ol class="wpri-sidebar">
			<?php
				$args = array( 'post_type' => 'wpri_news', 'posts_per_page' => 10 );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					echo "<a class='faculty-thumb-link' href='".site_url()."/news/".$post->post_name."'>";
						echo '<div>';
						the_title();
		  				echo '</div>';
					echo "</a>";
				endwhile;
			?>
		</ol>
	</div>
</div>
