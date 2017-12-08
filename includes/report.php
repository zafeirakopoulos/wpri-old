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

    $sheet1 = 'Projects';
    $header = array("string","string","string","string","string","integer");
    $writer->writeSheetHeader($sheet1, $header, $col_options = ['suppress_row'=>true] );
    $header_format = array('font'=>'Arial','font-size'=>10,'font-style'=>'bold,italic', 'fill'=>'#eee','color'=>'#f00','fill'=>'#ffc', 'border'=>'top,bottom', 'halign'=>'center');
    $writer->writeSheetRow($sheet1, array("Title","Member","Role","Status","Collaboratos","Budget"),$header_format);

    $rows = array(
        array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00',"233233"),
        array('2003','=B1', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00',"2423423"),
    );

    foreach($rows as $row){
        $writer->writeSheetRow($sheet1, $row);
    }
 }
else {}

$writer->writeToStdOut();
exit(0);
