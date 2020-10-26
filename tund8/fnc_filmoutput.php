<?php
$database = "if20_inga_filmibaas_E";

function readpersonsinfilm($sortby, $sortorder){
	$notice = "<p>Kahjuks filme ja tegelasi ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	
	if($sortby == 0 and $sortorder == 0){
		$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
	}
	if($sortby == 4){
		if($sortorder == 1){
			$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id ORDER BY title");
		} else {
			$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id ORDER BY title DESC");
		}
	}
	
	echo $conn->error;
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
	$stmt->execute();
	$lines = "";
	while($stmt->fetch()){
		$lines .= "<tr> \n";
		$lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td>";
		$lines .= "\t <td>" .$rolefromdb ."</td>";
		$lines .= "\t <td>" .$titlefromdb ."</td> \n";
		$lines .= "</tr> \n";
	}
	if(!empty($lines)){
		$notice = "<table> \n";
		$notice .= "<tr> \n";
		$notice .= "<th>Isik</th><th>Roll</th>";
		$notice .= '<th>Film &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
		$notice .= "</tr> \n";
		$notice .= $lines;
		$notice .= "</table> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}
