<?php
  //$username = "Andrus Rinde";
  session_start();
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	  //jõugu sisselogimise lehele
	  header("Location: page.php");
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	   header("Location: page.php");
	   exit();
  }
  
  //testin klassi
  //require("classes/Generic_class.php");
  //loome uue instantsi
  //$myfirstinstance = new Generic();
  //echo "Salajane number on: " .$myfirstinstance->secretnumber;
  //echo "Avalik number on: " .$myfirstinstance->availablenumber;
  //$myfirstinstance->tellSecret();
  //$myfirstinstance->showValues();
  //unset($myfirstinstance);
  //$myfirstinstance->showValues();
  //echo "Avalik number on: " .$myfirstinstance->availablenumber;
  
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a>!</p>
  <ul>
    <li><a href="listideas.php">Mõtete näitamine</a></li>
	<li><a href="addideas.php">Mõtete lisamine</a></li>
	<li><a href="listfilms.php">Filmiinfo näitamine</a></li>
	<li><a href="addfilms.php">Filmiinfo lisamine</a></li>
	<li><a href="addfilmrelations.php">Filmi seoste määramine</a></li>
	<li><a href="listfilmpersons.php">Filmitegelased</a></li>
	<li><a href="userprofile.php">Oma profiili haldamine</a></li>
	<li><a href="photoupload.php">Fotode üleslaadimine</a></li>
  </ul>
  
</body>
</html>






