#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../3rd-party/PHPExcel.php';


$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load('/tmp/EvtMgr-template.XLS');
var_dump($objPHPExcel->getActiveSheet()->getStyle('A1'));




$sheet = $objPHPExcel->getActiveSheet()->setTitle("EventMgr");

exit(0);

