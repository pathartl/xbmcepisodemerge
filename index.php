<?php include 'functions.php' ?>

<style>
	.episode-number, .episode-name, .aired-date, .merge-with {
		text-align: center
	}
</style>

XBMC Episode Merger
<br><br>

<form action="index.php" method="post">
	TheTVDB Series ID: <input type="text" name="SeriesID">
	<input type="submit" value="Change" name="changeseries">
</form>

<form action="index.php" method="post">
<?php
	
	// Get out show's data from TheTVDB
	if ($_POST['SeriesID']) {
	    $SeriesID = $_POST['SeriesID'];
	} elseif ($_GET['SeriesID']) {
	    $SeriesID = $_GET['SeriesID'];
	} else {
	    $SeriesID = "";
	}

	$file = 'http://thetvdb.com/data/series/'.$SeriesID.'/all/';
	if (!$xml = simplexml_load_file($file))
		exit("Failed to open " / $file);

	// Start outputting info from TheTVDB
	echo "Series Name: ";
	print_r((string) $xml->Series->SeriesName);
	
	// Start our massive table
	?><table width="100%"><?php
	
	// Create useful table headers
	echo '<tr id="table-header">' .
		'<td class="episode-number">Episode Number</td>' .
		'<td class="episode-name">Episode Name</td>' .
		'<td class="aired-date">Aired Date</td>' .
		'<td class="merge-with">Merge With</td>' .
		'<td class="download-nfo">Download NFO</td>' .
	     '</tr>';

	// Grab info about each episode
	foreach ($xml->Episode as $episode) {
		echo '<tr id="' . $episode->id . '">';
		// Make our episode number in the S01E01 format
		echo '<td class="episode-number">S' .
			sprintf('%02s', $episode->SeasonNumber) .
			'E' . sprintf('%02s', $episode->EpisodeNumber) .
			'</td>';
		echo '<td class="episode-name">' . $episode->EpisodeName . '</td>';
		echo '<td class="aired-date">' . $episode->FirstAired . '</td>';
		echo '<td class="merge-with">' . 
			'S' . sprintf('%02s', $episode->SeasonNumber) .
			'E<input type="text" ' . 
			'name="' . $episode->id . '" ' .
			'value="' . sprintf('%02s', $episode->EpisodeNumber) . '"</input>';
		echo '<td class="download-nfo"><input type="submit" value="Download NFO" name="download"></td>';
		echo '</tr>';
	}
?>
</table>
</form>

