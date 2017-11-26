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
 * Menu functionality.
 *
 * Menu functionality.
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

        $menus =  array();
        $declarations = WPRI_Declarations::get_declarations();
        foreach ($declarations as $entity_name => $entity) {
            if (isset($entity["has_menu"])){
                array_push($menus,$entity_name );
            }
        }
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
     public function __construct($entity) {
        $GLOBALS["entity"] = $entity;
        add_menu_page( "wpri-".$entity["title"]."-menu" , $entity["title"], $entity["actions"]["add"], "wpri-".$entity["title"], "menu_page_callback" );

        # Nested functions act like globally defined.
        function menu_page_callback() {
           echo '<div class="wrap">';
           echo "<h2>"$GLOBALS["entity"]["title"]."</h2>";
           echo '</div>';
       };
    }
}
