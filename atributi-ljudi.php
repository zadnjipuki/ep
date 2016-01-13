<?php
include 'database-methods.php';

//to je klicano direktno iz vsi-main: preberemo podatke,ki jih uporabnik odda za obdelavo


if(isset($_GET["izvor"]) && $_GET["izvor"]== "zunaj"){
   $tip = $_GET["tip"];
   $funkcija = $_GET["funkcija"];
   
   
   if($funkcija == "administrator" || $funkcija == "prodajalec"){
        if($tip == "novo" ){ 
            
            ?>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
		
                Ime <input type="text" name="ime" /><br>
                Priimek<input type="text" name="priimek" /><br>
                Email <input type="text" name="email"> <br>
		Geslo <input type="text" name="geslo" /><br>
                <input type="hidden" name="funkcija" value = "prodajalec" />
                <input type="hidden" name="izvor" value = "znotraj" />
                <input type="hidden" name="tip" value = "novo" /><br>
		<input type="submit" value="Dodaj">
            </form>
        <?php
        }
        
        else if ($tip == "posodobi" && $sebe = "ne"){
            ?>
            <h1>Vsi prodajalci</h1>
            <?php
            try {
                $vsiProdajalci = DBTrgovina::getVsiZaposleni($funkcija);
            } catch (Exception $e) {
                echo "Prišlo je do napake: {$e->getMessage()}";
            }

            foreach ($vsiProdajalci as $num => $row) {
                $url = $_SERVER["PHP_SELF"] . "?tip=posodobi&funkcija=prodajalec&id=" . $row["id_zaposleni"];
                /*
                $email = $row["email"];
                $geslo = $row["geslo"];
                
                $status = $row["status"];
                 * */
                 
                $ime = $row["ime"];
                $priimek = $row["priimek"];
                echo "<p><b>$ime</b>:$priimek [<a href='$url'>Uredi</a>]</p>\n";
            }
        }
        
    }
    
    else if($funkcija == "stranka"){
        if($tip == "novo" ){ ?>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
		
                Ime <input type="text" name="ime" /><br>
                Priimek<input type="text" name="priimek" /><br>
                Email <input type="text" name="email"> <br>
		Geslo <input type="text" name="geslo" /><br>
                Naslov <input type="text" name="naslov" /><br>
                Telefon <input type="text" name="telefon" /><br>
                <input type="hidden" name="funkcija" value = "stranka" />
                <input type="hidden" name="izvor" value = "znotraj" />
                <input type="hidden" name="tip" value = "novo" /><br>
                
		<input type="submit" value="Dodaj">
            </form>
        <?php
        }
        else if ($tip == "posodobi" && $sebe = "ne"){
            ?>
            <h1>Vse stranke</h1>
            <?php
            try {
                $vseStranke = DBTrgovina::getVseStranke();
            } catch (Exception $e) {
                echo "Prišlo je do napake: {$e->getMessage()}";
            }

            foreach ($vseStranke as $num => $row) {
                $url = $_SERVER["PHP_SELF"] . "?tip=posodobi&funkcija=stranka&id=" . $row["id_stranke"];
                /*
                $email = $row["email"];
                $geslo = $row["geslo"];
                
                $status = $row["status"];
                 * */
                 
                $ime = $row["ime"];
                $priimek = $row["priimek"];
                $email = $row["email"];
                echo "<p><b>$ime</b>:$priimek:$email [<a href='$url'>Uredi</a>]</p>\n";
            }
        }
    }
    else if($funkcija == "artikel"){
        if($tip == "novo" ){ ?>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
		
                Ime <input type="text" name="ime" />
                Cena<input type="text" name="cena" />
                
                Funkcija <input type="hidden" name="funkcija" value = "artikel" />
                Izvor <input type="hidden" name="izvor" value = "znotraj" />
                Tip <input type="hidden" name="tip" value = "novo" />
                
		<input type="submit" value="Dodaj">
            </form>
        <?php
        }
        else if ($tip == "posodobi"){
            ?>
            <h1>Vsi artikli</h1>
            <?php
            try {
                $vsiPredmeti = DBTrgovina::getVsiIzdelki();
            } catch (Exception $e) {
                echo "Prišlo je do napake: {$e->getMessage()}";
            }

            foreach ($vsiPredmeti as $num => $row) {
                $url = $_SERVER["PHP_SELF"] . "?tip=posodobi&funkcija=artikel&id=" . $row["id_izdelka"];
             
                $ime = $row["ime"];
                $cena = $row["cena"];
                $status = $row["status"];
                
                echo "<p><b>$ime</b>:$cena:$status [<a href='$url'>Uredi</a>]</p>\n";
            }
        }
    }
    
}

// to pa je klicano od znotraj: torej prebrane podatke obdelamo in posodabljamo bazo
else if(isset($_POST["izvor"])){
    if($_POST["tip"] == "novo" && $_POST["funkcija"] == "prodajalec"){ // ce je isset true, potem vemo da je noter ker le od noter je post, zato ne preverjam vrednosti

            $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $funkcija  = $_POST["funkcija"];

        DBTrgovina::dodajZaposlenega($funkcija,$ime,$priimek,$email,$geslo);

        
    }
    
    else if( $_POST["tip"] == "novo" && $_POST["funkcija"] == "stranka"){
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $funkcija  = $_POST["funkcija"];
        $naslov = $_POST["naslov"];
        $telefon = $_POST["telefon"];
        DBTrgovina::dodajStranko($funkcija,$ime,$priimek,$email,$geslo,$naslov,$telefon);
    }

    else if($_POST["tip"] == "novo" && $_POST["funkcija"] == "artikel"){
        $ime = $_POST["ime"];

        $funkcija  = $_POST["funkcija"];
        $cena = $_POST["cena"];

        $cena = floatval($cena);

        DBTrgovina::dodajPredmet($ime,$cena);
    }

    else if ($_POST["tip"] == "posodobi" && $_POST["funkcija"] != "stranka" && $_POST["funkcija"] != "artikel" ){
            
            ?>
            <h1>Posodobitev zaposlenega</h1>
            <?php
            try{
                //$geslo = password_hash($url, $algo)
                DBTrgovina::updateZaposleni($_POST["id"],$_POST["ime"],$_POST["priimek"],$_POST["email"],$_POST["geslo"],$_POST["status"]);
                echo "Posodobitev je bila uspesna." ;
            } catch (Exception $e) {
                echo "<p>Napaka pri zapisu: {$e->getMessage()}.</p>";
            }


    }
     else if ($_POST["tip"] == "posodobi" && $_POST["funkcija"] == "stranka"  ){
            
            ?>
            <h1>Posodobitev stranke</h1>
            <?php
            try{
                //$geslo = password_hash($url, $algo)
                DBTrgovina::updateStranka($_POST["id"],$_POST["ime"],$_POST["priimek"],$_POST["email"],$_POST["geslo"],$_POST["naslov"],$_POST["telefon"],$_POST["status"]);
                echo "Posodobitev je bila uspesna.";
            } catch (Exception $e) {
                echo "<p>Napaka pri zapisu: {$e->getMessage()}.</p>";
            }


    }
    else if ($_POST["tip"] == "posodobi" && $_POST["funkcija"] == "artikel"  ){
            
            ?>
            <h1>Posodobitev artikla</h1>
            <?php
            try{
                //$geslo = password_hash($url, $algo)
                DBTrgovina::updatePredmet($_POST["id"],$_POST["ime"],$_POST["cena"],$_POST["status"]);
                echo "Posodobitev je bila uspesna.";
            } catch (Exception $e) {
                echo "<p>Napaka pri zapisu: {$e->getMessage()}.</p>";
            }


    }
    
}   



//to je vmesna stopnja pri posodablojanju atributev iz noter pride in noter se enkrat klice
//izjema je podsodabljane svojih atributov ko dejansko pridde od zunaj ampak se tukaj izvede
else{
    if($_GET["funkcija"] == "prodajalec"){
        if(isset($_GET["id"])) $id = $_GET["id"];
        else {
            $email = $_GET["email"];
            $id = DBTrgovina::findIdZaposleni($email);
        }
        
        ?>
            <h1>Urejanje</h1>
            <?php
            try {
                $row = DBTrgovina::getZaposleni($id); // POIZVEDBA V PB
            } catch (Exception $e) {
                echo "Napaka pri poizvedbi: " . $e->getMessage();
            }
            
            $email = $row["email"];
             //$geslo = $row["geslo"];
                
             $status = $row["status"];
                
            $ime = $row["ime"];
            $priimek = $row["priimek"];
            ?>
            <h2>Urejanje atributov osebe z id = <?= $id ?></h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="posodobi" />
                <input type="hidden" name="funkcija" value="prodajalec" />
                Ime <input type="text" name="ime" value="<?= $ime ?>" /><br />
                Priimek <input type="text" name="priimek" value="<?= $priimek ?>" /><br />
                Email <input type="text" name="email" value="<?= $email ?>" /><br />
                Novo geslo <input type="text" name="geslo" /><br />
                Status <input type="text" name="status" value="<?= $status ?>" /><br />
                <input type="submit" value="Shrani" />
            </form>
               <!--
            <h2>Izbris zapisa</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="do" value="delete" />
                <input type="submit" value="Briši" />
            </form>
               -->
            <?php
    }
    else if($_GET["funkcija"] == "stranka"){
            
        if(isset($_GET["id"])) $id = $_GET["id"];
        else {
            $email = $_GET["email"];
            $id = DBTrgovina::findIdStranke($email);
        }
        ?>
            <h1>Posodabljanje</h1>
            <?php
            try {
                $row = DBTrgovina::getStranka($id); // POIZVEDBA V PB
            } catch (Exception $e) {
                echo "Napaka pri poizvedbi: " . $e->getMessage();
            }
            
            $email = $row["email"];
            $geslo = $row["geslo"];
            $naslov = $row["naslov"];
            $telefon = $row["telefon"];
            $status = $row["status"];    
            $ime = $row["ime"];
            $priimek = $row["priimek"];
            ?>
            <h2>Urejanje atributov osebe z id = <?= $id ?></h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="posodobi" />
                <input type="hidden" name="funkcija" value="stranka" />
                Ime <input type="text" name="ime" value="<?= $ime ?>" /><br />
                Priimek <input type="text" name="priimek" value="<?= $priimek ?>" /><br />
                Email <input type="text" name="email" value="<?= $email ?>" /><br />
                Novo geslo (lahko vneses starega) <input type="text" name="geslo" /><br />
                Naslov <input type="text" name="naslov" value="<?= $naslov ?>" /><br />
                Telefon <input type="text" name="telefon" value="<?= $telefon ?>" /><br />
                Status <input type="text" name="status" value="<?= $status ?>" /><br />
                <input type="submit" value="Shrani" />
            </form>
               <!--
            <h2>Izbris zapisa</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="do" value="delete" />
                <input type="submit" value="Briši" />
            </form>
               -->
            <?php
    }
    else if($_GET["funkcija"] == "artikel"){
            ?>
            <h1>Posodabljanje</h1>
            <?php
            try {
                $row = DBTrgovina::getPredmet($_GET["id"]); // POIZVEDBA V PB
            } catch (Exception $e) {
                echo "Napaka pri poizvedbi: " . $e->getMessage();
            }
            $id = $_GET["id"];
           
            $status = $row["status"];    
            $ime = $row["ime"];
            $cena = $row["cena"];
            ?>
            <h2>Urejanje atributov izdelka z id = <?= $id ?></h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="posodobi" />
                <input type="hidden" name="funkcija" value="artikel" />
                Ime <input type="text" name="ime" value="<?= $ime ?>" /><br />
                Cena <input type="text" name="cena" value="<?= $cena ?>" /><br />
                Status <input type="text" name="status" value="<?= $status ?>" /><br />
                <input type="submit" value="Shrani" />
            </form>
               <!--
            <h2>Izbris zapisa</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="do" value="delete" />
                <input type="submit" value="Briši" />
            </form>
               -->
            <?php
    }
    
}






