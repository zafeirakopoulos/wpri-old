<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Shortcodes {

	public function shortcodes_init()
	{
	    add_shortcode('wpri-project', 'shortcode_project');
	}


	function shortcode_project($atts = [], $content = null)
	    {
			 
			$atts = array_change_key_case((array)$atts, CASE_LOWER);
			$table_name = $GLOBALS['wpdb']->prefix . 'wpri_project' ; 

			if (isset($atts['id'])){
		 		$html = get_project_html($atts['id']);
			}
			else{
				$results= $GLOBALS['wpdb']->get_results("SELECT * FROM " . $table_name);
			$html = "<div><h1> All projects </h1><br>" ;
				foreach ($results as $result){
					$html .= get_project_html($result->id); 
					$html .= "<br>"; 
				}
				$html .= "</div>";			
			}
		    return  $html;
	    }

}
