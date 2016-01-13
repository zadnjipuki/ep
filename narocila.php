<?php
include 'database-methods.php';

//zunanje
if(isset($_GET["izvor"])&& $_GET["izvor"]=="zunaj"){
    $stanje =$_GET["tip"];
    try {
              $narocila = DBTrgovina::findNarocila($stanje);
            } catch (Exception $e) {
                echo "Prišlo je do napake: {$e->getMessage()}";
            }
    if($stanje=="neobdelano"){
       
            foreach ($narocila as $num => $row) {
                $url = $_SERVER["PHP_SELF"] . "?do=potrdi&tip=neobdelano&izvor=znotraj&id=" . $row["id_narocila"];
                $url2 = $_SERVER["PHP_SELF"] . "?do=preklici&tip=neobdelano&izvor=znotraj&id=" . $row["id_narocila"]; 
                $id_narocila = $row["id_narocila"];
                $id = $row["id_stranke"];
                $datum = $row["datum"];
                $stranka = DBTrgovina::getStranka($id);
                
                /*
                 Stranka: <input type="text" name="" value="<?= $ime+$priimek ?>" />
                Datum <input type="text" name="" value="<?= $datum ?>" />
                 */
                
                $ime = $stranka["ime"];
                $priimek = $stranka["priimek"];
                echo "id narocila: $id_narocila stranka: $ime $priimek datum: $datum ";
                ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" style="display: inline;">
                <input type="hidden" name="do" value="potrdi" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="neobdelano" />
                <input type="hidden" name="id" value="<?= $id_narocila ?>" />
                <input type="hidden" name="stanje" value="<?= $stanje ?>" />
                <input type="submit" value="Potrdi narocilo" />
                </form>

                 <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" style="display: inline;">
                <input type="hidden" name="do" value="preklici" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="neobdelano" />
                <input type="hidden" name="id" value="<?= $id_narocila ?>" />
                <input type="hidden" name="stanje" value="<?= $stanje ?>" />
                <input type="submit" value="Preklici narocilo" />
                </form>
                <?php
                //echo "<p><b> id narocila: $id_narocila stranka: $ime $priimek datum: $datum </b>[<a href='$url'>Potrdi narocilo</a>]  [<a href='$url2'>Preklici narocilo</a>]</p>\n";
            }
    }
    else if($stanje=="potrjeno"){
        foreach ($narocila as $num => $row) {
                $url = $_SERVER["PHP_SELF"] . "?method=post&do=storniraj&tip=neobdelano&izvor=znotraj&id=" . $row["id_narocila"];
                
                $id_narocila = $row["id_narocila"];
                $id = $row["id_stranke"];
                $datum = $row["datum"];
                $stranka = DBTrgovina::getStranka($id);
                
                $ime = $stranka["ime"];
                $priimek = $stranka["priimek"];
                
                echo "id narocila: $id_narocila stranka: $ime $priimek datum: $datum ";
                ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" style="display: inline;">
                <input type="hidden" name="do" value="storniraj" />
                <input type="hidden" name="izvor" value="znotraj" />
                <input type="hidden" name="tip" value="potrjeno" />
                <input type="hidden" name="id" value="<?= $id_narocila ?>" />
                <input type="hidden" name="stanje" value="<?= $stanje ?>" />
                <input type="submit" value="Storniraj narocilo" />
                </form>
                 <?php
                
              
         }
    }
}

else if(isset($_POST["izvor"])&& $_POST["izvor"]=="znotraj"){
    echo "tuki";
    $stanje =$_POST["tip"];
    $id_narocila = $_POST["id"];
    $do = $_POST["do"];
    if($do=="storniraj"){
       //izbrisem narocilo pa tudi tabelo s kuplejnimi izdelki posodobim
        DBTrgovina::izbrisiNarocilo($id_narocila);
    }
    else if($do=="potrdi"){
        DBTrgovina::spremeniStanjeNarocila($id_narocila,"potrjeno");
    }
    else if($do=="preklici"){
        DBTrgovina::spremeniStanjeNarocila($id_narocila,"preklicano");
    }
}

