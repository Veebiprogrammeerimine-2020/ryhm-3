<?php
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
  
  //loeme andmebaasi login ifo muutujad
  require("../../../../config_vp2020.php");
  require("fnc_user.php");
  
  
  //kui klikiti nuppu, siis kontrollime ja salvestame
  $notice = "";
  $description = readdescription();

  
  //algatuseks valin vaikimisivärvid
  /*$_SESSION["txtcolor"] = "#000000";
  $_SESSION["bgcolor"] = "#FFFFFF";*/
  if(isset($_POST["profilesubmit"])){
	$notice = storeuserprofile($_POST["descriptioninput"], $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
	$description = $_POST["descriptioninput"];
	$_SESSION["txtcolor"] = $_POST["txtcolorinput"];
  $_SESSION["bgcolor"] = $_POST["bgcolorinput"];
  }
  
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> kasutajaprofiil</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    
  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="descriptioninput">Minu lühitutvustus: </label><br>
	<textarea rows="10" cols="80" name="descriptioninput" id="descriptioninput" placeholder="Minu tutvustus ..."><?php echo $description; ?></textarea>
	<br>
	<label for="bgcolorinput">Minu valitud taustavärv: </label>
	<input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["bgcolor"]; ?>">
	<br>
	<label for="txtcolorinput">Minu valitud tekstivärv: </label>
	<input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["txtcolor"]; ?>">
	<br>
	<input type="submit" name="profilesubmit" value="Salvesta profiil">
  </form>
  <p><?php echo $notice; ?></p>
  
</body>
</html>






