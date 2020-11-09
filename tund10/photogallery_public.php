<?php
  //SESSIOON
  require("classes/Session.class.php");
  //sessioon, mis katkeb, kui brauser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~rinde/", "greeny.cs.tlu.ee");
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	  header("Location: page.php");
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	   header("Location: page.php");
	   exit();
  }
  
  require("../../../../config_vp2020.php");
  require("fnc_photo.php");
  
  $notice = "";
  $origphotodir = "../photoupload_orig/";
  $normalphotodir = "../photoupload_normal/";
  $thumbphotodir = "../photoupload_thumb/";
  
  //loen sisse pildid, mille privaatsus on 2 või 3
  $publicphotothumbsHTML = readPublicPhotosThumbs(2);
  
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
  
  <h2>Fotogalerii</h2>
  <?php
	echo $publicphotothumbsHTML;
  ?>

</body>
</html>






