<?php

function generate_nfo() {
	// For each argument
	foreach (func_get_args() as $episode) {
		// If the current episode in the loop is the last episode set $lastepisode true
		if ($episode = func_get_arg(func_num_args() - 1)) $lastepisode = true;
		echo $lastepisode;
	}
}

?>
