XBMC Episode Merger
<br><br>
<?php

	$file = 'http://thetvdb.com/data/series/75164/all/';
	if (!$xml = simplexml_load_file($file))
		exit("Failed to open " / $file);
	echo "Series Name: ";
	print_r((string) $xml->Series->SeriesName);
	
	?><table><?php

	echo '<tr id="table-header">' .
		'<td>Episode Number</td>' .
		'<td>Episode Name</td>' .
	     '</tr>';

	foreach ($xml->Episode as $episode) {
		echo '<tr id="' . $episode->id . '">';
		echo '<td>S' .
			sprintf("%02s", $episode->SeasonNumber) .
			'E' . sprintf("%02s", $episode->EpisodeNumber) .
			"</td>";
		echo '<td>' . $episode->EpisodeName . "</td>";
		echo '</tr>';
	}

?></table>
