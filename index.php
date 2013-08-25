XBMC Episode Merger
<br><br>
<?php
	
	// Get out show's data from TheTVDB
	$file = 'http://thetvdb.com/data/series/'.$_GET['SeriesID'].'/all/';
	if (!$xml = simplexml_load_file($file))
		exit("Failed to open " / $file);

	// Start outputting info from TheTVDB
	echo "Series Name: ";
	print_r((string) $xml->Series->SeriesName);
	
	// Start our massive table
	?><table><?php
	
	// Create useful headers
	echo '<tr id="table-header">' .
		'<td>Episode Number</td>' .
		'<td>Episode Name</td>' .
		'<td>Aired Date</td>' .
	     '</tr>';

	// Grab info about each episode
	foreach ($xml->Episode as $episode) {
		echo '<tr id="' . $episode->id . '">';
		// Make our episode number in the S01E01 format
		echo '<td>S' .
			sprintf('%02s', $episode->SeasonNumber) .
			'E' . sprintf('%02s', $episode->EpisodeNumber) .
			'</td>';
		echo '<td>' . $episode->EpisodeName . '</td>';
		echo '<td>' . $episode->FirstAired . '</td>';
		echo '</tr>';
	}

?></table>
