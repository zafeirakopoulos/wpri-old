<?php
include_once("xlsxwriter.class.php");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$filename = "$_GET['id'].xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$writer = new XLSXWriter();
$writer->setAuthor('Some Author');

if ($_GET["id"]==1) {

    $rows = array(
        array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00'),
        array('2003','=B1', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
    );

    foreach($rows as $row)
    	$writer->writeSheetRow('Sheet1', $row);
}
else {}

$writer->writeToStdOut();
exit(0);
