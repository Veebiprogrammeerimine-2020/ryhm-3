<?php

  //käivitan sessiooni
  //session_start();
  
  //SESSIOON
  require("classes/Session.class.php");
  //sessioon, mis katkeb, kui brauser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~rinde/", "greeny.cs.tlu.ee");
  
  //loeme andmebaasi login ifo muutujad
  require("../../../../config_vp2020.php");
  require("fnc_common.php");
  require("fnc_user.php");
  
  
  //$username = "Andrus Rinde";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  
  //vaatame, mda vormist serverile saadetakse
  //var_dump($_POST);
  
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //küsime nädalapäeva
  $weekdaynow = date("N");
  //echo $weekdaynow;
  
  if($hournow < 6){
	  $partofday = "uneaeg";
  }
  if($hournow >= 6 and $hournow < 8){
	  $partofday = "hommikuste protseduuride aeg";
  }
  if($hournow >= 8 and $hournow < 18){
	  $partofday = "akadeemilise aktiivsuse aeg";
  }
  if($hournow >= 18 and $hournow < 22){
	  $partofday = "õhtuste toimetuste aeg";
  }
  if($hournow >= 22){
	  $partofday = "päeva kokkuvõtte ning magamamineku aeg";
  }
  
  //jälgime semestri kulgu
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new DateTime("now");
  $fromsemesterstart = $semesterstart->diff($today);
  //saime aja erinevuse objektina, seda niisama näidata ei saa
  $fromsemesterstartdays = $fromsemesterstart->format("%r%a");
  $semesterpercentage = 0;
    
  $semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
  if($semesterstart > $today){
	  $semesterinfo = "Semester pole veel peale hakanud!";
  }
  if($fromsemesterstartdays === 0){
	  $semesterinfo = "Semester algab täna!";
  }
  if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
  }
  if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
  }
  
  //loen kataloogist piltide nimekirja
  //$allfiles = scandir("../vp_pics/");
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  //echo $allfiles;  //massiivi nii näidata ei saa!!!
  //var_dump($allfiles);
  //$allpicfiles = array_slice($allfiles, 2);
  //var_dump($allpicfiles);
  $allpicfiles = [];
  $picfiletypes = ["image/jpeg", "image/png"];
  //käin kogu massiivi läbi ja kontrollin iga üksikut elementi, kas on sobiv fail ehk pilt
  foreach ($allfiles as $file){
	  $fileinfo = getImagesize("../vp_pics/" .$file);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true){
		  array_push($allpicfiles, $file);
	  }
  }
  
  //paneme kõik pildid järjest ekraanile
  //uurime, mitu pilti on ehk mitu faili on nimekirjas - massiivis
  $piccount = count($allpicfiles);
  //echo $piccount;
  //$i = $i + 1;
  //$i += 1;
  //$i ++;
  $imghtml = "";
  /* for($i = 0; $i < $piccount; $i ++){
	  //<img src="../img/vp_banner.png" alt="alt tekst">
	  $imghtml .= '<img src="../vp_pics/' .$allpicfiles[$i] .'" ';
	  $imghtml .= 'alt="Tallinna Ülikool">';
  } */
  $imghtml .= '<img src="../vp_pics/' .$allpicfiles[mt_rand(0, ($piccount - 1))] .'" ';
  $imghtml .= 'alt="Tallinna Ülikool">';
  
  $email = "";
  
  $emailerror = "";
  $passworderror = "";
  $notice = "";
  if(isset($_POST["submituserdata"])){
	  if (!empty($_POST["emailinput"])){
		//$email = test_input($_POST["emailinput"]);
		$email = filter_var($_POST["emailinput"], FILTER_SANITIZE_EMAIL);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		} else {
		  $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
		}		
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki).";
		  }
	  }
	  
	  if(empty($emailerror) and empty($passworderror)){
		  //echo "Juhhei!" .$email .$_POST["passwordinput"];
		  $notice = signin($email, $_POST["passwordinput"]);
	  }
  }

  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Äge veebisüsteem</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <hr>
  <h3>Logi sisse</h3>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="emailinput">E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
	  <br>
	  <label for="passwordinput">Salasõna:</label>
	  <br>
	  <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	  <br>
	  <br>
	  <input name="submituserdata" type="submit" value="Logi sisse"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
  </form>
  <hr>
  <p>Loo omale <a href="addnewuser.php">kasutajakonto</a>!</p>
  <hr>
  <p>Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow - 1] .", " .$fulltimenow; ?>. 
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  <hr>

  <?php echo $imghtml; ?>
  
</body>
</html>






