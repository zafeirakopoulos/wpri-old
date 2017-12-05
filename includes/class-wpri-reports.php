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
		$writer->writeToStdOut();
		//$writer->writeToFile('example.xlsx');
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
        	// };
			?> <button type="submit" onclick="window.open('excel_report.xlsx')">Download!</button> <?php
			// echo "	<button class='navbar-btn' onclick='wpri_get_report(\"excel_report.xlsx\")'> report</button>";
    	add_submenu_page( "wpri-reports-menu", $entity["title"],$entity["title"], $entity["actions"]["add"], "wpri-report-".$entity["title"],$callback);
    }

}
