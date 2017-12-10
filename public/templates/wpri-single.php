
<div class='single'>
	<?php
	$post = get_post(get_the_ID());

	// foreach ($post as $key => $value) {
	// 	echo $key." = ".$value;
	// }
	echo "<h1 class='single'>";
	the_title();
	echo "</h1><br>";

 	if ($post->post_type=="wpri_news"){
		echo $post->post_type;

		echo 	"<div class='entry'>";
		the_content();
		echo "</div>";
	}
	elseif ($post->post_type=="wpri_highlights") {
		echo 	"<div class='entry'>";
		the_content();
		echo "</div>";	}
	elseif ($post->post_type=="wpri_blog") {
		echo $post->post_type;

		echo 	"<div class='entry'>";
		the_content();
		echo "</div>";
	}
	elseif ($post->post_type=="wpri_project_blog") {
		echo 	"<div class='entry'>";
		the_content();
		echo "</div>";
	}


	?>
	<div>
     <?php
			 previous_post_link( '%link', '%title', TRUE );
			 echo next_post_link('%link', 'Next Post >>', $in_same_term = true, $excluded_terms = '', $taxonomy = $post->post_type);
		?>
	</div>
</div>


	<!-- if ($post->post_type=="wpri_news"){
		// [ID] =>
	    // [post_author] =>
	    // [post_date] =>
	    // [post_date_gmt] =>
	    // [post_content] =>
	    // [post_title] =>
	    // [post_excerpt] =>
	    // [post_status] =>
	    // [comment_status] =>
	    // [ping_status] =>
	    // [post_password] =>
	    // [post_name] =>
	    // [to_ping] =>
	    // [pinged] =>
	    // [post_modified] =>
	    // [post_modified_gmt] =>
	    // [post_content_filtered] =>
	    // [post_parent] =>
	    // [guid] =>
	    // [menu_order] =>
	    // [post_type] =>
	    // [post_mime_type] =>
	    // [comment_count] =>
	    // [filter] =>
	} -->
