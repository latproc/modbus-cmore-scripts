#!/usr/bin/php
<?php
$shortopts = "i:o:";

$options = getopt($shortopts);

if(!isset($options['i']) || !file_exists($options['i'])) {
	die("input file does not exists\n");
}

if(!isset($options['o']) || !is_string($options['o'])) {
	die("output options must be set\n");
}

if (($hin = fopen($options['i'], "r")) === FALSE) {
	die("unable to open input file " . $options['i'] . "\n");
}

if (($hout = fopen($options['o'], "w")) === FALSE) {
	die("unable to open output file for write " . $options['o'] . "\n");
}

echo "Input: {$options['i']} Output: {$options['o']}\n";

$Headings = array ('ProtocolID','DeviceName','TagName','DataType',
					'DataCount','Retentive','Address','ArrayStart','ArrayEnd');

$result = fputcsv($hout, $Headings, ',', '"');

while( ($data = fgetcsv($hin, 0, "\t")) !== FALSE) {
	$type = substr($data[0],0,1);
	$address = "'" . $type . substr($data[0],3);
	$point = (string)$data[1];
	$type = (string) ($data[2] == 'Coil') ? 'Discrete' : $data[2];
	$Line = array ('211', 'LATPROC', $point, $type, '1', 'FALSE', $address, '0', '0');
	$result = fputcsv($hout, $Line, ',', '"');

}
fclose($hin);
fclose($hout);
?>
