<?php
$database = "if20_inga_filmibaas_E";

function readpersonsinfilm(){
	$notice = "<p>Kahjuks filme ja tegelasi ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id;");
	echo $conn->error;
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
	$stmt->execute();
	$lines = "";
	while($stmt->fetch()){
		$lines .= "<p>" .$firstnamefromdb ." " .$lastnamefromdb;
		if(!empty($rolefromdb)){
			$lines .= " mängis tegelast: " .$rolefromdb;
		}
		$lines .= ' filmis "' .$titlefromdb .'".</p>' ."\n";
	}
	if(!empty($lines)){
		$notice = $lines;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}
