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


		function shortcode_project($atts = [], $content = null)
		    {
				 
				function get_project_html($project_id)
				{
					$table_name = $GLOBALS['wpdb']->prefix . 'wpri_project' ; 

					$result= $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare("SELECT * FROM " . $table_name . " WHERE id = %d", $project_id));
					$project = $result[0];
				    $html = "<div>";
					$html .= "<h2>" . $result[0]->title . "</h2><br>";
				    $html .= "website: " . $result[0]->website . "<br>";
				    $html .= "Funded by " . $result[0]->funding . "<br>";
					$html .= "</div>";
					return $html;
				}
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
	    add_shortcode('wpri-project', 'shortcode_project');
	}




}
