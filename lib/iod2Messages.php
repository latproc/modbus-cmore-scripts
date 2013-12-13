#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/phpExcelHelpers.php';
require_once dirname(__FILE__) . '/latproc.php';
require_once dirname(__FILE__) . '/../3rd-party/PHPExcel.php';

$shortopts = 'o:';

$options = getopt($shortopts);

if(!isset($options['o']) || !is_string($options['o'])) {
	die('output options must be set\n');
}

if (($hout = fopen($options['o'], 'w')) === FALSE) {
	die('unable to open output file for write ' . $options['o'] . '\n');
}
fclose($hout);
unlink($options['o']);

echo "Output: {$options['o']}\n";

$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . '/MsgDB-template.XLS');
$sheet = $objPHPExcel->getActiveSheet();

$property_list = get_iod_property_list(array('name','msg','id','type','blink', 'textcolor', 'textsize'), array('type','id'));
$row = 3;
foreach ($property_list as $line) {
	if ($line['type'] != 'message') continue;
	$id = $line['id'];
	$TextForeColor = (isset($line['textcolor'])) ? (int)$line['textcolor'] : 15;
	$TextForeBlink = (isset($line['blink'])) ? (bool)$line['blink'] : FALSE;
	$Size = (isset($line['textsize'])) ? (int)$line['textsize'] : 10;
	//$msg = $line['msg'];
	$msg = substr(trim($line['msg']),0,254);
	$RowData =   array( $id, $TextForeColor, $TextForeBlink, 0, FALSE, $Size, FALSE, FALSE, NULL, 0, $msg);
	$sheet->insertNewRowBefore($row, 1);
	array2row($sheet, $RowData, $row);
	$row ++;
}
$row = $row - 4;
echo "Imported {$row} rows\n";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($options['o']);

?>
