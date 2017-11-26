<?php

/**
 * Menus.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * Functionality about project management.
 *
 * Functionality about project management.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Menu {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public function wpri_menus() {

        $menus =  array("project" );
        $declarations = WPRI_Declarations::get_declarations();

        foreach ($menus as $menu_name){
            new wpri_menu($declarations[$menu_name]);
        }
	}



}
class anotherclass {
}
