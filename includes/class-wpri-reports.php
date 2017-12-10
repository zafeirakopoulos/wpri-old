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
		$callback = function() use ($entity){
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=projects\"'> Projects</button>";
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=2\"'> report</button>";
			echo "<button class='navbar-btn' onclick='window.location.href = \"../report?id=3\"'> report</button>";
			};
		add_menu_page( "Reports Management", "Reports", "manage_options", "wpri-reports-menu",$callback);

 
	}


	public  function download_report_page_template( $template ) {

		if ( is_page("report") ) {
			$template = dirname( __FILE__ ) . '/report.php';
		}
		return $template;
	}
}
