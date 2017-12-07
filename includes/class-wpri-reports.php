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

	public static function get_report() {
		$name = "excel_report.xlsx";
		error_log(XLSXWriter::sanitize_filename($name));
		error_log($name);
		header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($name).'"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$rows = array(
		    array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00'),
		    array('2003','=B1', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
		);
		$writer = new XLSXWriter();
		$writer->setAuthor('Some Author');
		foreach($rows as $row)
			$writer->writeSheetRow('Sheet1', $row);
		// $writer->writeToStdOut();
		$writer->writeToFile($name);
		//echo $writer->writeToString();
		// die(1);
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
			// echo "<form method='get' action='excel_report.xlsx'>
			// <button class='navbar-btn' onclick='wpri_get_report(\"excel_report.xlsx\")'> report</button>
			// </form>";

			// echo '<button type="submit" onclick="window.open(\'excel_report.xlsx\')">Download!</button>';
			echo "	<button class='navbar-btn' onclick='wpri_get_report(\"excel_report.xlsx\")'> report</button>";
			};
    	add_submenu_page( "wpri-reports-menu", $entity["title"],$entity["title"], $entity["actions"]["add"], "wpri-report-".$entity["title"],$callback);
    }

}

// if (!class_exists('DownloadCSV')) {
//   class DownloadCSV {
//     static function on_load() {
//       add_action('plugins_loaded',array(__CLASS__,'plugins_loaded'));
//       add_action('admin_menu',array(__CLASS__,'admin_menu'));
//       register_activation_hook(__FILE__,array(__CLASS__,'activate'));
//     }
//     static function activate() {
//       $role = get_role('administrator');
//       $role->add_cap('download_csv');
//     }
//     static function admin_menu() {
//       add_submenu_page('tools.php',    // Parent Menu
//         'Download CSV',                // Page Title
//         'Download CSV',                // Menu Option Label
//         'download_csv',                // Capability
//         'tools.php?download=data.csv');// Option URL relative to /wp-admin/
//     }
//     static function plugins_loaded() {
//       global $pagenow;
//       if ($pagenow=='tools.php' &&
//           current_user_can('download_csv') &&
//           isset($_GET['download'])  &&
//           $_GET['download']=='data.csv') {
//         header("Content-type: application/x-msdownload");
//         header("Content-Disposition: attachment; filename=data.csv");
//         header("Pragma: no-cache");
//         header("Expires: 0");
//         echo 'data';
//         exit();
//       }
//     }
//   }
//   DownloadCSV::on_load();
// }
