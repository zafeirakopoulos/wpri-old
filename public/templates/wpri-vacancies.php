<div class='single' id="vanacies" >
    <h1 class="outfont"> Open positions </h1>
        <ul class="list-group">
 			<?php
			$vacancy_ids= WPRI_Database::get_ids("vacancy");
 			foreach ( $vacancy_ids as $vacancy_id ) {
				$vacancy = WPRI_Database::get_entity("vacancy",$vacancy_id);
                echo "<a href='".site_url()."/position?id=".$vacancy_id."' class='list-group-item'>".$vacancy['official_title']." (".$vacancy['deadline'].")</a>";
			}
 			?>
        </ul>
 </div>
