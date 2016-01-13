<?php
echo "ja";
include 'database-methods.php';
#include 'Izdelek.php';
echo "ja";
$izdelki = DBTrgovina::getVSiIzdelkiKosaricaSlike();
echo "ja";
if(isset($_GET["id"])){
    $slike = DBTrgovina::getVseSlike($_GET["id"]);
    foreach ($slike as $slika){
        
        $slika = "slike_izdelkov/" . $slika;
        echo "$slika";
        ?> <img src="<?php echo $slika; ?> " /> <?php
    }
}
else{
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Moja kosarica</title>
    </head>
    <body>
        <h1>Spletna trgovina</h1>
        <h2>Ponudba artiklov</h2>
        <table>
            <tr>
                <td><b>Ime</b></td>
                <td><b>Cena</b></td>
                <td></td>
            </tr>

            <?php foreach ($izdelki as $izdelek): ?>

                <tr>
                    
                    <td><?= $izdelek->ime ?></td>
                    <td><?= number_format($izdelek->cena, 2, ',', '.') ?> €</td>
                    <td>
                        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET">
                            <input type="hidden" name="id" value="<?= $izdelek->id ?>" />
                            <input type="submit" value="Oglejte si slike" />
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        </body>

</html>

<?php

}
?>