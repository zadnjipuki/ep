<?php
include '../database-methods.php';
        #$authorized_users = ["Paula","Darja","paula@gmail.com"];
        $authorized_users = DBTrgovina::getProdajalci();
        
     

        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        if ($client_cert == null) {
            die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');
        }


        $cert_data = openssl_x509_parse($client_cert);
        $commonname = (is_array($cert_data['subject']['emailAddress']) ?
                        $cert_data['subject']['emailAddress'][0] : $cert_data['subject']['emailAddress']);
        if (in_array($commonname, $authorized_users)) {
            ?>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>Spletna trgovina</title>
            </head>
            <body>
                <p>Pozdravljen prodajalec, za nadaljevanje se prijavite spodaj.</p>
                <?php
                #chdir("netbeans/spletna_trgovina");
                #system("cd ..");
                 ?>
                
                <h3><a href=<?= "../get-prijava-vsi.php?&funkcija=prodajalec"?>>Prijava prodajalec</a></h3>

 
        <?php
            
        } else {
            echo "Niste avtoriziran uporabnik.";
        }

        #echo "<p>Vsebina certifikata: ";
        #var_dump($cert_data);


 ?>
 

<?php