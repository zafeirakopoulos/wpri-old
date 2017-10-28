
			<div class='single'  >
				<?php
				$post = get_post(get_the_ID());
				echo $post->post_type;
				if ($post->post_type=="wpri_news"){

				}
				else {
					foreach ($post as $key => $value) {
						echo $key." = ".$value;
					}
				}

				?>
				Links:
                 <?php
 					 previous_post_link( '%link', '%title', TRUE );
				 ?>

 	                <?php
						echo next_post_link('%link', 'Next Post >>', $in_same_term = true, $excluded_terms = '', $taxonomy = 'wpri_news');
					?>
 			</div>
