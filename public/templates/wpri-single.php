
			<div class='single'  >
				<?php

				$post = get_post(get_the_ID());
				if ($post->post_type=="wpri-news"){

				}
				else {
					foreach ($post as $key => $value) {
						echo $key." = ".$value;
					}
				}

				?>
				<div class="previous-post-link">
                <?php previous_post_link('%link', '<< Previous Post', $in_same_term = true, $excluded_terms = '', $taxonomy = 'wpri-news'); ?>
	            </div>

	            <div class="next-post-link">
	                <?php next_post_link('%link', 'Next Post >>', $in_same_term = true, $excluded_terms = '', $taxonomy = 'wpri-news'); ?>
	            </div>
			</div>
