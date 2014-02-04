<?php

function currentUrl() {
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
    $host     = $_SERVER['HTTP_HOST'];
    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];

    return $protocol . '://' . $host . $script . '?' . $params;
}

function array_average($array) {

	$average = 0;
	$handicap = 0;

	foreach ($array as $value) {
		if ($value == 0) {
			$handicap++;
		}
		$average += $value;
	}

	$average = ($average / (count($array) - $handicap));

	return $average;

}

?>
