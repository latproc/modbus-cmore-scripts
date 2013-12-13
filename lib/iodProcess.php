<?php

require_once dirname(__FILE__) . '/latproc.php';
$property_list = get_iod_property_list(array('name','msg','id','type','blink', 'textcolor', 'textsize'), array('type','id'));
var_dump($property_list);








?>
