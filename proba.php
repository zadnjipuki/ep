<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.1.1. Set the 'ServerName' directive globally to suppress this message

 */
session_start();
session_destroy();

echo "JAZ SEM PAULA";
$showimage = "slike_izdelkov/jakna_1.jpg";
?>
    <img src="<?php echo $showimage; ?> " />
     <img src="<?php echo $showimage; ?>" />
      