Cartoon Combiner for XBMC
<br><br>
<?php

	//$var->load("http://thetvdb.com/data/series/75164/all/");
	//echo $var;
	$file = 'http://thetvdb.com/data/series/75164/all/';
	if (!$xml = simplexml_load_file($file))
		exit("Failed to open " / $file);
	echo "Series Name: ";
	print_r((string) $xml->Series->SeriesName);
	foreach ($xml->Episode as $episode) {
		echo $episode->EpisodeName . "<br>";
	}
	 //$a = json_decode(json_encode((array) simplexml_load_string($s)),1);
	 //print_r($a);

?>