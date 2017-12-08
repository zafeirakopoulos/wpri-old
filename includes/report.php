<?php
include_once("xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$filename = $_GET['id'].".xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$writer = new XLSXWriter();
$writer->setAuthor('Some Author');

if ($_GET["id"]=="projects") {

    $sheet_projects = 'Projects';
    $header = array("string","string","string","integer"=>"GENERAL","string","string");
    $writer->writeSheetHeader($sheet_projects, $header, $col_options = ['suppress_row'=>true] );
    $header_format = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold,italic', 'fill'=>'#eee','color'=>'#f00','fill'=>'#ffc', 'border'=>'top,bottom', 'halign'=>'center');
    $writer->writeSheetRow($sheet_projects, array("Title","Status","Funding","Budget","Members","Collaborators"),$header_format);

    $projects=  WPRI_Database::get_all("project");
    $title=" ";
    $status=" ";
    $agency=" ";
    $budget=0;
    $member=" ";
    $role=" ";
    $collaborators=" ";

    foreach($projects as $project){

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
        // $member= array();
        // foreach($members as $membr){
        //     $mem = WPRI_Database::get_record("member",$membr["member"]);
        //     array_push($member,["name"] );
        // }
        // $member = join(",", $member);
        $role=" ";
        $collaborators=" ";

        $writer->writeSheetRow($sheet_projects, array($title,$status,$agency,$budget,$member,$role,$collaborators));

    }
 }
else {}

$writer->writeToStdOut();
exit(0);
