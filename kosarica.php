<?php
session_start();
static $id_stranke;
include 'database-methods.php';

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$validationRules = ['do' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ["regexp" => "/^(add_into_cart|update_cart|purge_cart)$/"]
    ],
    'id' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' => 0]
    ],
    'kolicina' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' => 0]
    ]
];
$data = filter_input_array(INPUT_POST, $validationRules);
if(isset($_GET["id_stranke"])) {
    $id_stranke = $_GET["id_stranke"];
    $_SESSION["id_uporabnika"] = $_GET["id_stranke"];
}
switch ($data["do"]) {
    case "add_into_cart":
        try {
            $izdelek = DBTrgovina::getPredmetKosarica($data["id"]);

            if (isset($_SESSION["cart"][$izdelek->id])) {
                $_SESSION["cart"][$izdelek->id] ++;
            } else {
                $_SESSION["cart"][$izdelek->id] = 1;
            }
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
        break;
    case "update_cart":
        if (isset($_SESSION["cart"][$data["id"]])) {
            if ($data["kolicina"] > 0) {
                $_SESSION["cart"][$data["id"]] = $data["kolicina"];
            } else {
                unset($_SESSION["cart"][$data["id"]]);
            }
        }
        break;
    case "purge_cart":
        $kupljeniIzdelki = array();
        $stevec=0;
        foreach ($_SESSION["cart"] as $id => $kolicina){
            $kupljeniIzdelki[$stevec]= array();
            $kupljeniIzdelki[$stevec]["id"] = $id;
            $kupljeniIzdelki[$stevec]["kolicina"]=$kolicina;
            $stevec++;
        }
        DBTrgovina::vnesiNaroceneIzdelke($kupljeniIzdelki,$_SESSION["id_uporabnika"],$_SESSION["skupaj"]);
        echo "Vas nakup je bil uspesen.";
        unset($_SESSION["cart"]);
        break;
    default:
        break;
}
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

            <?php foreach (DBTrgovina::getVsiIzdelkiKosarica() as $izdelek): ?>

                <tr>
                    
                    <td><?= $izdelek->ime ?></td>
                    <td><?= number_format($izdelek->cena, 2, ',', '.') ?> €</td>
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="do" value="add_into_cart" />
                            <input type="hidden" name="id" value="<?= $izdelek->id ?>" />
                            <input type="submit" value="V košarico" />
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Vsebina nakupovalne košarice</h2>

        <?php if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0): ?>
            <table>
                <tr>
                    <td><b>Izdelek</b></td>
                    <td><b>Količina</b></td>
                    <td><b>Skupaj</b></td>
                </tr>
                <?php
                $skupaj = 0;
                foreach ($_SESSION["cart"] as $id => $kolicina):
                    $izdelek = DBTrgovina::getPredmetKosarica($id);
                    $skupaj += $izdelek->cena * $kolicina;
                    ?>
                    <tr>
                        <td><?= $izdelek?></td>
                        <td>
                            <form action="<?= $url ?>" method="POST">
                                <input type="hidden" name="do" value="update_cart" />
                                <input type="hidden" name="id" value="<?= $izdelek->id ?>" />
                                <input type="text" name="kolicina" value="<?= $kolicina ?>" size="1" />
                                <input type="submit" value="Posodobi" />
                            </form>
                        </td>
                        <td><?= number_format($izdelek->cena * $kolicina, 2, ',', '.') ?> €</td>
                    </tr>
                <?php endforeach; 
                $_SESSION["skupaj"] = $skupaj;
                ?>
                <tr>
                    <td rowspan="3">Skupaj: 
                        <b><?= number_format($skupaj, 2, ',', '.') ?> €</b>
                    </td>
                </tr>
            </table>

            <form action="<?= $url ?>" method="POST">
                <input type="submit" name="do" value="purge_cart" />
                <input type="submit" value="Izprazni košarico" />
            </form>
        <?php else: ?>
            <p>Košarica je trenutno prazna.</p>
        <?php endif; ?>
    </body>
</html>
