<?php
include_once("xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$members = WPRI_Database::get_members_full();


/**********************************
*********** FILENAME **************
**********************************/

$filename =  array();

if ($_GET['type']=="personal"){
    $filename[] =  str_replace(' ', '', $members[$_GET['id']]["name"]); ;
}
if ($_GET['annual']=="1"){
    $filename[] =  $_GET['year'];
}
$filename[] =  $_GET['report'];
$filename = join("_", $filename);
$filename = $filename.".xlsx";
error_log($filename);

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

if ($_GET["report"]=="projects") {
    $sheet = 'Projects';
    $header = array("string","string","string","integer"=>"GENERAL","string","string");
    $column_titles= array("Title","Status","Funding","Budget","Members","Collaborators");
} elseif ($_GET["report"]=="students") {
    $sheet = 'Students';
    $header = array("string","string","string","string","string","integer"=>"GENERAL");
    $column_titles= array("Name","Advisor","Status","Level","Graduate","Graduation year");
} elseif ($_GET["report"]=="courses") {
    $sheet = 'Courses';
    $header = array("string","string","string","string");
    $column_titles= array("Code","Name","Instructor","Semester");
} elseif ($_GET["report"]=="publications") {
    $sheet = 'Publications';
    $header = array("string","string","string","string","integer"=>"GENERAL","string");
    $column_titles= array("Title","Type","Member","Authors","Year","Venue");
}

$writer->writeSheetHeader($sheet, $header, $col_options = ['suppress_row'=>true] );
$writer->writeSheetRow($sheet,$column_titles ,$header_format);

/**********************************
*********** CONTENT ***************
**********************************/

if ($_GET["report"]=="projects") {

    $projects=  WPRI_Database::get_all("project");
    $title=" ";
    $status=" ";
    $agency=" ";
    $budget=0;
    $member=" ";
    $role=" ";
    $collaborators=" ";

    foreach($projects as $project){
        $start = new DateTime($project["startdate"]);
        $end = new DateTime($project["enddate"]);
        error_log($start->format('y'));
        error_log("today ".date('y'));

        if (($_GET["annual"]!="1") || (($start->format('y')<= date('y')) && ($end->format('y')>= date('y')))) {
            $title=$project["official_title"];
            $status=   WPRI_Database::get_record("status",$project["status"])["status"];
            $agencies = WPRI_Database::get_relation("project","agency", $project["id"],"");
            $agency= array();
            foreach($agencies as $agenci){
                array_push($agency, WPRI_Database::get_record("agency",$agenci["agency"])["agency"] );
            }
            $agency = join(",", $agency);
            $budget=$project["budget"];

            $members = WPRI_Database::get_double_relation("project","member", "projectrole", $project["id"],"","");
            $member= array();
            foreach($members as $membr){
                $mem = WPRI_Database::get_record("member",$membr["member"]);
                $pr = WPRI_Database::get_record("projectrole",$membr["projectrole"]);
                array_push($member,$mem["name"]." (".$pr["projectrole"].")");
            }
            $member = join(",", $member);

            $collaborators = WPRI_Database::get_double_relation("project","collaborator", "projectrole", $project["id"],"","");
            $collaborator= array();
            foreach($collaborators as $collaborato){
                $col = WPRI_Database::get_record("collaborator",$collaborato["collaborator"]);
                $pr = WPRI_Database::get_record("projectrole",$collaborato["projectrole"]);
                array_push($collaborator,$collaborato["name"]." (".$pr["projectrole"].")");
            }
            $collaborator = join(",", $collaborator);
            $role=" ";

            $writer->writeSheetRow($sheet, array($title,$status,$agency,$budget,$member,$role,$collaborator));
        }
    }
 }

 /**********************************
 *********** OUTPUT  ***************
 **********************************/

$writer->writeToStdOut();
exit(0);
