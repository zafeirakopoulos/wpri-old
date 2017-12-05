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


	public function wpri_reports() {
		// $callback = function() use ($entity){
        //     // TODO ?
        // };
		// add_menu_page( "wpri-reports-menu", "Reports", "manage_options", "wpri-reports",$callback);
        //
        // $menus =  array();
        // $declarations = WPRI_Declarations::get_reports();
        // foreach ($declarations as $entity_name => $entity) {
        //     if (isset($entity["has_menu"])){
        //         array_push($menus,$entity_name );
        //     }
        // }
        // foreach ($menus as $menu_name){
        //     new wpri_report_menu_factory($declarations[$menu_name]);
        // }
	}

	public static function get_report() {


		$filename = "example.xlsx";
		header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
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
            WPRI_Form::wpri_create_form($entity);
        };
        add_submenu_page( "wpri-reports-menu","wpri-report-".$entity["title"]."-menu" , $entity["title"], $entity["actions"]["add"], "wpri-report-".$entity["title"],$callback);
    }
}
