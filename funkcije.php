<?php
  function preveriPrijavo($vseStranke, $email, $geslo){ //function parameters, two variables.
    $check = False;
      
        foreach ($vseStranke as $key => $row){
            $trenutniMail = $row["email"];
            
            if($trenutniMail === $email){
               $trenutnoGeslo = $row["geslo"];
                if(password_verify($geslo, $trenutnoGeslo)) $check = True;
                else $check = False;
                break;
            }
        }
    
   
   return $check;
  }
?>

