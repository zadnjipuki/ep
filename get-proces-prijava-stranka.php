<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Uspesna prijava</title>
</head>
<body><?php
include 'funkcije.php';
include 'database-methods.php';
$email = $_GET["email"];
$geslo = $_GET["geslo"];
$funkcija = $_GET["funkcija"];


 

try{
    //$hash = password_hash($geslo,PASSWORD_DEFAULT);
    
    if($funkcija == "stranka")$vsiLjudje = DBTrgovina::getVseStranke();
    else $vsiLjudje = DBTrgovina::getVsiZaposleni($funkcija);
}
catch (Exception $e) {
    echo "Prišlo je do napake: {$e->getMessage()}";
}

if(preveriPrijavo($vsiLjudje,$email,$geslo)){
    session_start();
     echo "Pozdravljeni. Vasa prijava je veljavna.";
     echo "session start";
    if($funkcija == "stranka"){ ?>
        <form action="vsi-main.php" method="get">
		<input type="hidden" name="email" value= "<?= $email ?>" />
                <input type="hidden" name="funkcija" value= stranka />
		<input type="submit" value="Nadaljuj">
        </form>
    <?php
    }
    if($funkcija == "administrator"){ ?>
        <form action="vsi-main.php" method="get">
		<input type="hidden" name="email" value= "<?= $email ?>" />
                <input type="hidden" name="funkcija" value= administrator />
		<input type="submit" value="Nadaljuj">
        </form>
    <?php
    }
    
    else{
        ?>
        <form action="vsi-main.php" method="get">
                <input type="hidden" name="email" value= "<?= $email ?>" />
                <input type="hidden" name="funkcija" value= prodajalec />
		<input type="submit" value="Nadaljuj">
        </form>
    <?php
    }
    
    
   
    
}
//if(1 ==1) echo preveriPrijavo($vsiLjudje,$email,$geslo);
else{
    echo "Vneseni podatki so napacni, poskusite ponovno.";
    ?>
    <form action="get-prijava-vsi.php" method="get">
		<input type="hidden" name="napacna_prijava" value = "fnedskf"> 
	 
		<input type="submit" value="Poiskusi ponovno">
    </form>
    <?php
   
}


?></body>
</html>
