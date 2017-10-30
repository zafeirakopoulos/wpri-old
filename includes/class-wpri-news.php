<?php

/**
 * Functions managing the news posts.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functions managing the news posts.
 *
 * Functions managing the news posts.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_News {



	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */


	public static function create_news_posttype() {
		  register_post_type( 'wpri_news',
		    array(
		      'labels' => array(
		        'name' => __( 'News' ),
		        'singular_name' => __( 'News' )
		      ),
		      'public' => true,
		      'has_archive' => true,
		      'rewrite' => array('slug' => 'news'),
		    )
		  );
	  }


	  	public static function create_highlights_posttype() {
	  		  register_post_type( 'wpri_highlights',
	  		    array(
	  		      'labels' => array(
	  		        'name' => __( 'Highlights' ),
	  		        'singular_name' => __( 'Highlight' )
	  		      ),
	  		      'public' => true,
	  		      'has_archive' => true,
	  		      'rewrite' => array('slug' => 'highlights'),
	  		    )
	  		  );
	  	  }

	  public static function create_member_blog_posttype() {
  		  register_post_type( 'wpri_member_blog',
  		    array(
  		      'labels' => array(
  		        'name' => __( 'Blog' ),
  		        'singular_name' => __( 'Blog' )
  		      ),
  		      'public' => true,
  		      'has_archive' => true,
  		      'rewrite' => array('slug' => 'blogs'),
  		    )
  		  );
  	  }
}
