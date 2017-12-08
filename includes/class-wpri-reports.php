<?php

/**
 * Declarations of entities and relations.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    wpri
 * @subpackage wpri/includes
 */

/**
 * FDeclarations of entities and relations.
 *
 * FDeclarations of entities and relations.
 *
 * @since      1.0.0
 * @package    wpri
 * @subpackage wpri/includes
 * @author     Zafeirakis Zafeirakopoulos
 */
class WPRI_Report {


	public static function wpri_reports() {
		$callback = function() {
            // TODO ?
        };
		add_menu_page( "Reports Management", "Reports", "manage_options", "wpri-reports-menu",$callback);

        $menus =  array();
        $declarations = WPRI_Declarations::get_reports();
        foreach ($declarations as $entity_name => $entity) {
            if (isset($entity["has_menu"])){
                array_push($menus,$entity_name );
            }
        }
        foreach ($menus as $menu_name){
        	new wpri_report_menu_factory($declarations[$menu_name]);
        }
	}


	public  function download_report_page_template( $template ) {

		if ( is_page("report") ) {
			$template = dirname( __FILE__ ) . '/report.php';
		}
		return $template;
	}
}


/**
 * Menu class
 *
 * @author Zafeirakis Zafeirakopoulos
 */
class wpri_report_menu_factory {
     public function __construct($entity) {
        $callback = function() use ($entity){
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=projects\"'> Projects</button>";
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=2\"'> report</button>";
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=3\"'> report</button>";
			};
    	add_submenu_page( "wpri-reports-menu", $entity["title"],$entity["title"], $entity["actions"]["add"], "wpri-report-".$entity["title"],$callback);
    }

}
