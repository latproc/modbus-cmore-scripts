<?php
function get_iod_property_list($props,$filters='') {
	$debug_messages = '';

	$context = new ZMQContext();
	$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
	$requester->connect('tcp://localhost:5555');

	$requester->send('LIST JSON');
	$reply = $requester->recv();
	$config_entries_json = $reply;
	$config_entries = json_decode($reply);
	$res = json_last_error();
	if (json_last_error() != JSON_ERROR_NONE) {
		display_json_error($res, $reply);
		$config_entries = array();
	}

	$debug_messages .= var_export($config_entries, true);
	if(!is_array($props)) $props = array($props);
	if(!is_array($filters)) $filters = array($filters);

	$list = array();

	foreach ($config_entries as $curr) {
		$jump = FALSE;
		foreach ($filters as $filter) {
			if(!isset($curr->$filter)) {
				$jump = TRUE;
				break;
			}
		}
		if($jump === TRUE) continue;

		$line  = array();
		foreach ($props as $prop) {
//			$line[$prop] = '';
			if (isset($curr->$prop)) 
				$line[$prop] = $curr->$prop;
		}
		$list[] = $line;
	}
	return $list;
}

// ----------------- utility functions -------------
function display_json_error($res, $reply) {
	global $debug_messages;
	switch ($res) {
        case JSON_ERROR_DEPTH:
            $err =  ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            $err =  ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            $err =  ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            $err =  ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            $err =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            $err =  ' - Unknown error';
        break;
    }
	$debug_messages .= $err . '<br/>' . $reply . '<br/>';
}

?>
