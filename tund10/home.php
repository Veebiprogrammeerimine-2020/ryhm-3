<?php
  //$username = "Andrus Rinde";
  //session_start();
  
  //SESSIOON
  require("classes/Session.class.php");
  //sessioon, mis katkeb, kui brauser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~rinde/", "greeny.cs.tlu.ee");
  
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
  
  $lastvisitor = null;
  //tegeleme küpsistega - cookies
  //setcookie   see peab olema enne <html> elemendi algust      
  //(küpsise nimi, väärtus, aegumine, path (kataloog), domeen, https, http-only)
  setcookie("vpvisitorname", $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"], time() + (86400 * 8), "/~rinde/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  //vaatame, kas on olemas
  if(isset($_COOKIE["vpvisitorname"])){
	  $lastvisitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitorname"] .".</p>";
  } else {
	  $lastvisitor = "<p>Küpsiseid ei leitud, viimane külastaja pole teada.</p>";
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
  <hr>
  <h3>Viimane külastus</h3>
  <?php
	if(count($_COOKIE) > 0){
		echo "Küpsised on lubatud!";
	}
	echo $lastvisitor;
  ?>
  
</body>
</html>






