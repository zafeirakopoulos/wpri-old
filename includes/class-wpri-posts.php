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
class WPRI_Posts {



	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */


	public static function create_new_posttype() {
		$declarations = WPRI_Declarations::get_post_types();
		foreach ($declarations as $name => $options) {
			register_post_type( $name , $options);
		}
	}

}
