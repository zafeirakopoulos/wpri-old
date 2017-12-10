<div class='wpri-sidebar-frame'>
	<h1 class='wpri-sidebar'> News </h1>
		<ul class="list-group news-list">
			<?php
				$args = array( 'post_type' => 'wpri_news', 'posts_per_page' => 10 );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					echo "<a class='list-group-item' href='".site_url()."/news/".$post->post_name."'>";
						the_title();
					echo "</a>";
				endwhile;
			?>
		</ul>
</div>
