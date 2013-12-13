<?php

function array2row($sheet, $rowData, $row, $column = '0') {
	$col_index = 0;
	foreach ($rowData as $cell) {
		if(!is_null($cell)) {
				$sheet->setCellValue( int2col($column+$col_index) . $row, $cell);
		}
		$col_index ++;
	}
}

function arrayformat($format, $index) {
	$flen = strlen($format);
	if($flen < $index || $flen < 1) {
		return PHPExcel_Cell_DataType::TYPE_STRING;
	}
	$type = substr($format, $index, 1);
	switch($type) {
		case 'B':
			$type = PHPExcel_Cell_DataType::TYPE_BOOL;
		break;
		case 'I':
			$type = PHPExcel_Cell_DataType::TYPE_NUMERIC;
		break;
		case 'N':
			$type = PHPExcel_Cell_DataType::TYPE_NULL;
		break;
		case 'S':
		default:
			$type = PHPExcel_Cell_DataType::TYPE_STRING;
		break;
	}
	return $type;
}

function int2col ($columnNo) {
	$column = '';
	$base = ord('A');
	$chrsize = 1;
	$chrset = 0;

	do {
		if($columnNo >= 26) {
			$column[$chrsize] = chr($base + $chrset);
			$chrset ++;
		} else {
			$column[$chrsize-1] = chr($base + $columnNo);
		}
		$columnNo = $columnNo - 26;
	} while ($columnNo >= 0);

	return implode($column);
}

?>
