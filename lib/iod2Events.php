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

$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . '/EvtMgr-template.XLS');
$sheet = $objPHPExcel->getActiveSheet();

$property_list = get_iod_property_list(array('name','msg','id','type','display','blink', 'textcolor', 'textsize'), array('type','id'));
$row = 3;
foreach ($property_list as $line) {
	if ($line['type'] != 'event') continue;
	$id = $line['id'];
	$EventName = $line['name'];
	$TagName = strtoupper($line['name']);
	$TagType = "D";
	$Text1 = substr(trim($line['msg']),0,64);
	$TextColor = (isset($line['textcolor'])) ? (int)$line['textcolor'] : 15;
	$TextBackColor = 0;
	$TextBlink = (isset($line['blink'])) ? strtoupper($line['blink']) : FALSE;
	$BackBlink = FALSE;
	$Display = (isset($line['display'])) ? (bool)$line['display'] : FALSE;
	$RowData = array($id, $EventName, $TagName, $TagType, 'ON', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, TRUE, $Text1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, $Display, $TextColor, $TextBackColor, $TextBlink, $BackBlink);
	$sheet->insertNewRowBefore($row, 1);
	array2row($sheet, $RowData, $row);
	$row ++;
}
$row = $row - 4;
if ($row <= 4) 
	echo "Error Gettings Records\n";
else
	echo "Imported " . $row ." rows\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($options['o']);

?>
