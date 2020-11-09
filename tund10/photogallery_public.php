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
  
  $photocount = countPublicPhotos(2);
  //echo $photocount;
  $gallerylimit = 3;
  $page = 1;
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif(round($_GET["page"] - 1) * $gallerylimit >= $photocount){
	  $page = floor($photocount / $gallerylimit);
  } else {
	  $page = $_GET["page"];
  }
  
  //loen sisse pildid, mille privaatsus on 2 või 3
  //$publicphotothumbsHTML = readPublicPhotosThumbs(2);
  $publicphotothumbsHTML = readPublicPhotosThumbsPage(2, $gallerylimit, $page);
  
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
  <p>
	<?php
		if($page > 1){
			echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a> |' ." </span>\n";
		} else {
			echo "<span>Eelmine leht | </span> \n";
		}
		if($page * $gallerylimit < $photocount){
			echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a>' ." </span>\n";
		} else {
			echo "<span>Järgmine leht </span> \n";
		}
	?>
  </p>
  <?php
	echo $publicphotothumbsHTML;
  ?>

</body>
</html>






