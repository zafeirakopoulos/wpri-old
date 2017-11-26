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
            new wpri_menu_factory($declarations[$menu_name]);
        }
	}



}


/**
 * Menu class
 *
 * @author Zafeirakis Zafeirakopoulos
 */
class wpri_menu_factory {

    public $entity = null;
    /**
     * Autoload method
     * @return void
     */
    public function __construct($entity) {
        // error_log("Class constructed: ".$entity["title"]);

        $this->entity = $entity;
        add_menu_page( "wpri-".$entity["title"]."-menu" , $entity["title"], $entity["actions"]["add"], "wpri-".$entity["title"], "menu_page_callback" );
    }


    /**
     * Render menu
     * @return void
     */
    public function menu_page_callback() {
        echo '<div class="wrap">';
        echo '<h2>Submenu title</h2>';
        echo '</div>';
    }

}