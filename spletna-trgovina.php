
<?php
        $authorized_users = ["Paula","Darja"];

        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        if ($client_cert == null) {
            die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');
        }


        $cert_data = openssl_x509_parse($client_cert);
        $commonname = (is_array($cert_data['subject']['CN']) ?
                        $cert_data['subject']['CN'][0] : $cert_data['subject']['CN']);
        if (in_array($commonname, $authorized_users)) {
            echo "$commonname je avtoriziran uporabnik, zato vidi trenutni čas: " . date("H:i");
        } else {
            echo "$commonname ni avtoriziran uporabnik in nima dostopa do ure";
        }

        echo "<p>Vsebina certifikata: ";
        var_dump($cert_data);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Spletna trgovina</title>
    </head>
    <body>
        <h1>Spletna trgovina</h1>
        <h2>Obiskovalci</h2>
        
        <h3><a href=<?= "seznam-izdelkov.php"?>>Ponudba trgovine</a></h3>
 
        <h3><a href=<?= "get-prijava-vsi.php?&funkcija=stranka"?>>Prijavi se </a></h3>
 
        <h3><a href=<?= "atributi-ljudi.php?tip=novo&funkcija=prodajalec&izvor=zunaj"?>>Registriraj se</a></h3>
 
        
        <h2>Zaposleni</h2>
        <h3><a href=<?= "get-prijava-vsi.php?&funkcija=administrator"?>>Prijava administrator</a></h3>
 
        <h3><a href=<?= "get-prijava-vsi.php?&funkcija=prodajalec"?>>Prijava prodajalec</a></h3>
 
<?php

 ?>
 

<?php
