<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$members = WPRI_Database::get_members_full();


/**********************************
*********** FILENAME **************
**********************************/

$filename =  array();

if ($_GET['personal']=="1"){
    $filename[] =  str_replace(' ', '', $members[$_GET['id']]["name"]); ;
}
if ($_GET['annual']=="1"){
    $filename[] =  $_GET['y'];
}
$filename[] =  $_GET['report'];
$filename = join("_", $filename);
$filename = $filename.".xlsx";

/**********************************
*********** SETUP  ****************
**********************************/

header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$writer = new XLSXWriter();
$writer->setAuthor('BTE');

/**********************************
*********** FORMAT ****************
**********************************/

$header_format = array('font'=>'Arial','font-size'=>13,'font-style'=>'bold,italic', 'fill'=>'#eee','color'=>'#f00','fill'=>'#ffc', 'border'=>'top,bottom', 'halign'=>'center');

$sheet_projects = 'Projects';
$header_projects = array("string","string","string","integer"=>"GENERAL","string","string");
$column_titles_projects= array("Title","Status","Funding","Budget","Members","Collaborators");

$sheet_students = 'Students';
$header_students = array("string","string","string","string","string","integer"=>"GENERAL");
$column_titles_students= array("Name","Advisor","Status","Level","Graduate","Graduation year");

$sheet_courses = 'Courses';
$header_courses = array("string","string","string","string");
$column_titles_courses= array("Code","Name","Instructor","Semester");

$sheet_publications = 'Publications';
$header_publications = array("string","string","string","string","integer"=>"GENERAL","string");
$column_titles_publications= array("Title","Type","Member","Authors","Year","Venue");

if ($_GET["report"]=="general") {
    $writer->writeSheetHeader($sheet_projects, $header_projects, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_projects,$column_titles_projects ,$header_format);

    $writer->writeSheetHeader($sheet_students, $header_students, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_students,$column_titles_students ,$header_format);

    $writer->writeSheetHeader($sheet_courses, $header_courses, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_courses,$column_titles_courses ,$header_format);

    $writer->writeSheetHeader($sheet_publications, $header_publications, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_publications,$column_titles_publications ,$header_format);
} elseif ($_GET["report"]=="projects") {
    $writer->writeSheetHeader($sheet_projects, $header_projects, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_projects,$column_titles_projects ,$header_format);
} elseif ($_GET["report"]=="students") {
    $writer->writeSheetHeader($sheet_students, $header_students, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_students,$column_titles_students ,$header_format);
} elseif ($_GET["report"]=="courses") {
    $writer->writeSheetHeader($sheet_courses, $header_courses, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_courses,$column_titles_courses ,$header_format);
} elseif ($_GET["report"]=="publications") {
    $writer->writeSheetHeader($sheet_publications, $header_publications, $col_options = ['suppress_row'=>true] );
    $writer->writeSheetRow($sheet_publications,$column_titles_publications ,$header_format);
}



/**********************************
*********** CONTENT ***************
**********************************/

if (isset($_GET['annual']) && $_GET['annual']==1){
    $annual = true;
} else{
    $annual = false;
}
if (isset($_GET['personal']) && $_GET['personal']==1){
    $personal = true;
} else{
    $personal = false;
}
$year = $_GET['y'];
$id = $_GET['id'];

if ($_GET["report"]=="general") {
    foreach (WPRI_Report::write_project_sheet($personal, $annual, $year, $id) as $row) {
        error_log(print_r($row));
        $writer->writeSheetRow($sheet_projects, $row);
    }


    // TODO
} elseif ($_GET["report"]=="projects") {
    foreach (WPRI_Report::write_project_sheet($personal, $annual, $year, $id) as $row) {
        error_log($row[0]);

        $writer->writeSheetRow($sheet_projects, $row);
    }
}
 /**********************************
 *********** OUTPUT  ***************
 **********************************/

$writer->writeToStdOut();
exit(0);
