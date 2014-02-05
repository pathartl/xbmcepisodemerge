<!DOCTYPE html>
<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php

		include 'config.php';
		include 'inc/functions.php';

		mysql_connect($database_server . ":" . $database_port,$database_user,$database_password);
		
		@mysql_select_db($database_name) or die( "Unable to select database");
		
		if ($_GET['id']) {
			$query="select * from episode where idShow=" . $_GET['id'];
		} else {
			$query="select * from tvshow";
		}
		$result = mysql_query($query);
		
		$season = 0;
		
		if ($mergequeue = $_POST['season-episode']) {
			// For each episode in the merge queue
			$unique = array_unique($mergequeue);
		 	foreach ($unique as $episode) {
		
		 		// Initialize Arrays
		 		$plot = array();
				$director = array();
				$title = array();
				$rating = array();
		
		
		 		// Check if there is another episode with the same number in the merge queue
		 		$result = array_count_values($mergequeue);
		 		
		 		// Find the keys of the other matching episodes
		 		$keys = array_keys($mergequeue, $episode);
		 		foreach ($keys as $key) {
		 			// Sanitized Episode Details
		 			$plot[] = $_POST['plot'][$key];
		 			$director[] = $_POST['director'][$key];
		 			$title[] = $_POST['title'][$key];
		 			$rating[] = $_POST['rating'][$key];
		 		}
		
		 		// Split the episode name into season and episode number
		 		$split = explode("E", substr($episode, 1));
		
		 		$directorsArray = array();
		
		 		// For each episode's director info
		 		foreach ($director as $item) {
		 			// Explode the episode's directors into an array
		 			$explodedDirectors = explode(" / ", $item);
		 			// Add each single directory name to one array
		 			foreach ($explodedDirectors as $singleDirector) {
		 				$directorsArray[] = $singleDirector;
		 			}
		 		}
		
				$uniqueDirector = array_unique($directorsArray);
		 		$nfo = "<episodedetails>\n" .
		 			"<title>" . implode(" / ", $title) . "</title>\n" .
		 			"<rating>" . array_average($rating) . "</rating>\n" .
		 			"<season>" . ltrim($split[0], 0) . "</season>\n" .
		 			"<episode>" . ltrim($split[1], 0) . "</episode>\n" .
		 			"<plot>" . implode(" | ", $plot) . "</plot>\n" .
		 			"<director>" . implode(" / ", $uniqueDirector) . "</director>\n" .
		 			"</episodedetails>\n\n";
		
		 		echo nl2br(htmlspecialchars($nfo));
		
		 		$filename = $output_dir . "/" . $episode . ".nfo";
				$handle = fopen($filename, 'w') or die("can't open file");
				fwrite($handle, $nfo);
				fclose($handle);
		
		 	}
		}
		
		?> 
		
		<form action="index.php" method="post">
		
		<?php
		while($row = mysql_fetch_array($result)){
		
			// Check if we don't have a show selected
			if (!$_GET['id']) {
		
				// We don't have a show selected
				// Print list of shows
		    	printf('<a href="?id=' . $row['idShow'] . '&title=' . $row['c00'] . '">' . $row['c00'] . "</a><br>");
		
			} else {
		
				// We do have a show selected
				// Check if we don't have a season selected
				if (!$_GET['season']) {
					if ($row['c12'] != $season) {
						?> <a href="<?php echo currentUrl(); ?>&season=<?php echo $row['c12'] ?>"><h2>Season <?php echo $row['c12']; ?></h2></a><?php
						$season = $row['c12'];
					}
		
				} else {
		
					// We do have a season selected
					// Episode Info
					if ($row['c12'] == $_GET['season']) {
					?>
					<div class="episode">
						<input size="6" class="season-episode" name="season-episode[]" value="<?php echo 'S' . str_pad($row['c12'], 2, "0", STR_PAD_LEFT) . 'E' . 
							str_pad($row['c13'], 2, "0", STR_PAD_LEFT); ?>">
		
						<!-- Make some hidden content with our episode details -->
						<input type="hidden" name="episodeID[]" value="<?php echo htmlspecialchars($row['idEpisode'], ENT_COMPAT); ?>">
						<input type="hidden" name="plot[]" value="<?php echo htmlspecialchars($row['c01'], ENT_COMPAT); ?>">
						<input type="hidden" name="director[]" value="<?php echo htmlspecialchars($row['c04'], ENT_COMPAT); ?>">
						<input type="hidden" name="title[]" value="<?php echo htmlspecialchars($row['c00'], ENT_COMPAT); ?>">
						<input type="hidden" name="rating[]" value="<?php echo htmlspecialchars($row['c03'], ENT_COMPAT); ?>">
						<input type="hidden" name="showTitle" value="<?php echo $_GET['title']; ?>">
		
							<h3><?php echo $row['c00']; ?></h3>
						<div class="ep-file" name="ep-file[]"><?php echo $row['c18']; ?></div>
						<div class="plot"><?php echo $row['c01']; ?></div>
					</div>
					<?php
					}
		
				}
		
			}
		
		}
		
		?>
		<input type="submit" value="Merge">
		</form>
	</body>
</html>