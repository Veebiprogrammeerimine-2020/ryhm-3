<?php
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
  //loeme andmebaasi login ifo muutujad
  require("../../../../config_vp2020.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_rinde_3";
  if(isset($_POST["submitnonsens"])){
	  if(!empty($_POST["nonsens"])){
		  //andmebaasi lisamine
		  //loome andmebaasi ühenduse
		  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		  //valmistame ette SQL käsu
		  $stmt = $conn->prepare("INSERT INTO nonsens (nonsensidea) VALUES(?)");
		  echo $conn->error;
		  //s - string, i -integer, d-decimal
		  $stmt->bind_param("s", $_POST["nonsens"]);
		  $stmt->execute();
		  //käsk ja ühendus sulgeda
		  $stmt->close();
		  $conn->close();
	  } 
  }
  
  //$username = "Andrus Rinde";
  
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Sisesta oma tänane mõttetu mõte!</label>
	<input type="text" name="nonsens" placeholder="mõttekoht">
	<input type="submit" value="Saada ära!" name="submitnonsens">
  </form>
  
</body>
</html>






