<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebileht</title>
  <style>
  <?php
    echo "body { \n";
	if(isset($_SESSION["bgcolor"])){
		echo "background-color: " .$_SESSION["bgcolor"] ."; \n";
	} else {
		echo "background-color: #FFFFFF; \n";
	}
	if(isset($_SESSION["txtcolor"])){
		echo "color: " .$_SESSION["txtcolor"] ."\n";
	} else {
		echo "color: #000000; \n";
	}
	echo "} \n";
  ?>
  </style>
</head>
<body>