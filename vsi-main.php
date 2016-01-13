<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Uspesna prijava</title>
</head>
<body><?php
include 'funkcije.php';
include 'database-methods.php';
$funkcija = $_GET["funkcija"];
$email = $_GET["email"];

if($funkcija == "administrator"){
 ?>
 <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=administrator&email=$email&sebe=da"?>>Posodobi moje atribute</a></h2>
 
 <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=prodajalec&sebe=ne&izvor=zunaj"?>>Posodobi atribute prodajalcev</a></h2>
 
  <h2><a href=<?= "atributi-ljudi.php?tip=novo&funkcija=prodajalec&izvor=zunaj"?>>Dodaj prodajalca</a></h2>
 
   <h2><a href=<?= "get-prijava-vsi.php"?>>Odjava</a></h2>

<?php
}

else if($funkcija == "stranka"){
    $id_stranke = DBTrgovina::findIdStranke($email);
 ?>
 <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=stranka&sebe=da&email=$email"?>>Posodobi moje atribute</a></h2>
 
 <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=prodajalec"?>>Preglej artikle trgovine</a></h2>
 
  <h2><a href=<?= "kosarica.php?id_stranke=$id_stranke"?>>Moja kosarica</a></h2>
  
  <h2><a href=<?= "atributi-ljudi.php?tip=novo&funkcija=prodajalec"?>>Pretekli nakupi</a></h2>
 
   <h2><a href=<?= "get-prijava-vsi.php"?>>Odjava</a></h2>

<?php
}

else{
 ?>
 <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=prodajalec&sebe=da&email=$email"?>>Posodobi moje atribute</a></h2>
 
 <h2><a href=<?= "narocila.php?tip=neobdelano&izvor=zunaj"?>>Ogled neobdelanih narocil</a></h2>
 
  <h2><a href=<?= "narocila.php?tip=potrjeno&izvor=zunaj"?>>Ogled potrjenih narocil</a></h2>
  
  <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=artikel&izvor=zunaj"?>>Posodobi atribute artiklov</a></h2>
  
  <h2><a href=<?= "atributi-ljudi.php?tip=novo&funkcija=artikel&izvor=zunaj"?>>Dodaj artikle</a></h2>
  
  <h2><a href=<?= "atributi-ljudi.php?tip=posodobi&funkcija=stranka&sebe=ne&izvor=zunaj"?>>Posodobi atribute strank</a></h2>
  
  <h2><a href=<?= "atributi-ljudi.php?tip=novo&funkcija=stranka&izvor=zunaj"?>>Dodaj nove stranke</a></h2>
 
   <h2><a href=<?= "get-prijava-vsi.php"?>>Odjava</a></h2>

<?php
}
?></body>
</html>