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
class WPRI_Post {



	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */


	public static function wpri_posts() {
		$declarations = WPRI_Declarations::get_post_types();
		foreach ($declarations as $name => $options) {
			register_post_type( $name , $options);
		}
		flush_rewrite_rules( false );


	 	function filter_locale( $atts , $content,$tag ){
				$all_locales = WPRI_Database::get_locales();
				foreach ($all_locales as $loc) {
					if ($loc["id"]==$_SESSION['locale']){
						$locale = $loc["locale"];
					}
				}
		    	if ($locale==$tag){
					return $content;
				}
				return "";
		}
		$all_locales = WPRI_Database::get_locales();
		foreach ($all_locales as $loc) {
			add_shortcode( $loc["locale"], 'filter_locale' );
			}

		add_filter( 'the_title', 'do_shortcode' );
	}

}
