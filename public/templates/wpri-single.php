
			<div class='single'  >
  dd rebre
				<?php

				$post = get_post(get_the_ID());
				foreach ($post as $key => $value) {
					echo $key." = ".$value
				}
				?>
			</div>
