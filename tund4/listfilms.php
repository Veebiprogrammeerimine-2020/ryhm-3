<?php
  //loeme andmebaasi login ifo muutujad
  require("../../../../config_vp2020.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  //$database = "if20_rinde_3";
  $database = "if20_inga_pe_1";
  
  //loeme andmebaasist
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //valmistame ette SQL käsu
  //$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
  $stmt = $conn->prepare("SELECT * FROM film");
  echo $conn->error;
  //seome tulemuse mingi muutujaga
  $stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
  $stmt->execute();
  $filmshtml = "\t <ol> \n";
  //võtan, kuni on
  while($stmt->fetch()){
	  //<p>suvaline mõte </p>
	  $filmshtml .= "\t \t <li>" .$titlefromdb ."\n";
	  $filmshtml .= "\t \t \t <ul> \n";
	  $filmshtml .= "\t \t \t \t <li>Valmimisaasta: " .$yearfromdb ."</li> \n";
	  $filmshtml .= "\t \t \t \t <li>Kestus: " .$durationfromdb ." minutit</li> \n";
	  $filmshtml .= "\t \t \t \t <li>Žanr: " .$genrefromdb ."</li> \n";
	  $filmshtml .= "\t \t \t \t <li>Tootja/stuudio: " .$studiofromdb ."</li> \n";
	  $filmshtml .= "\t \t \t \t <li>Lavastaja: " .$directorfromdb ."</li> \n";
	  $filmshtml .= "\t \t \t </ul> \n";
	  $filmshtml .= "\t \t </li> \n";
  }
  $filmshtml .= "\t </ol> \n";
  
  $stmt->close();
  $conn->close();
  //ongi andmebaasisit loetud

  $username = "Andrus Rinde";

  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    
  <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>
  
  <hr>
  <?php echo $filmshtml; ?>
</body>
</html>






