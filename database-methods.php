<?php

require_once 'database-init.php';
include 'Izdelek.php';
class DBTrgovina {
    
    
    public  static function vnesiNaroceneIzdelke($izdelki,$id_stranke,$znesek){
        $db = DBInit::getInstance();
        $stanje = "neobdelano";
        
        $statement = $db->prepare("INSERT INTO narocila (id_stranke, stanje,znesek)
            VALUES (:id, :stanje,:znesek) ");
        $statement->bindParam(":id", $id_stranke);
        $statement->bindParam(":stanje", $stanje);
        $statement->bindParam(":znesek", $znesek);
        $statement->execute();
        
        $statement = $db->prepare("SELECT MAX(id_narocila) FROM narocila WHERE id_stranke=:id");
        $statement->bindParam(":id", $id_stranke);
        $statement->execute();
        $id_nar = $statement->fetch();
        $id_narocila = reset($id_nar);
        
        foreach ($izdelki as $num => $row) {
             $statement = $db->prepare("INSERT INTO naroceni_izdelki (id_izdelka,id_narocila, stevilo_izdelkov)
             VALUES (:id1, :id2,:st)");
             $statement->bindParam(":id2", $id_narocila);
             $statement->bindParam(":id1", $row["id"]);
             $statement->bindParam(":st", $row["kolicina"]);
             
             $statement->execute();
      
        }
    }

    public static function getVsiIzdelkiKosarica(){
        $izdelki = DBTrgovina::getVsiIzdelki();
        $vrni = array();
        foreach ($izdelki as $num => $row) {
            $vrni[] = new Izdelek($row["ime"], $row["id_izdelka"], $row["cena"]);
      
        }
        return $vrni;
    }
    
    public static function getVsiIzdelkiKosaricaSlike(){
        $izdelki = DBTrgovina::getVsiIzdelki();
        $vrni = array();
        foreach ($izdelki as $num => $row) {
            
            $vrni[] = new Izdelek($row["ime"], $row["id_izdelka"], $row["cena"]);
      
        }
        return $vrni;
    }
    
    public static function getVseSlike($id_izdelka){
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT pot_slike FROM slike WHERE id_izdelka=:id");
        $statement->bindParam(":id", $id_izdelka);
        $statement->execute();
        
        $tabela =  $statement->fetchAll();
        $vrni = array();
        foreach ($tabela as $slika){
            $vrni[] = reset($slika);
        }
        return $vrni;
    }
    public static function getPredmetKosarica($id){
        $row = DBTrgovina::getPredmet($id);
        return new Izdelek($row["ime"], $row["id_izdelka"], $row["cena"]);
    }

    public static function getVsiIzdelki() {
        $db = DBInit::getInstance();
        $status = "aktiven";
        $statement = $db->prepare("SELECT id_izdelka, ime, cena, status FROM izdelki WHERE status=:status");
        $statement->bindParam(":status", $status);
        $statement->execute();
           
        return $statement->fetchAll();
    }
    public static function getVSeStranke(){
        //echo "sem v napacni funkciji";
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id_stranke, ime, priimek, email, geslo, naslov, telefon FROM stranke");
        
        $statement->execute();

        return $statement->fetchAll();
    }
     public static function getAdmin(){
        //echo "sem v pravi funkciji";
        $db = DBInit::getInstance();
        $funkcija = "administrator";
        $statement = $db->prepare("SELECT email FROM zaposleni WHERE funkcija = :funkcija");
        $statement->bindParam(":funkcija", $funkcija);
        $statement->execute();

        return  $statement->fetch();
        
    }
    
    public static function getProdajalci(){
        //echo "sem v pravi funkciji";
        $db = DBInit::getInstance();
        $funkcija = "prodajalec";
        $statement = $db->prepare("SELECT email FROM zaposleni WHERE funkcija = :funkcija");
        $statement->bindParam(":funkcija", $funkcija);
        $statement->execute();

        $return =  $statement->fetchAll();
        
        $vrni = array();
        foreach ($return as $slika){
            $vrni[] = reset($slika);
        }
        return $vrni;
        
    }
    
    public static function getVsiZaposleni($funkcija){
        //echo "sem v pravi funkciji";
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id_zaposleni, ime, priimek, email, geslo FROM zaposleni WHERE funkcija = :funkcija");
        $statement->bindParam(":funkcija", $funkcija, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }
    
    public static function getZaposleni($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT  ime, priimek, email, geslo, status FROM zaposleni WHERE id_zaposleni = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetch();
    }
    
    public static function getStranka($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT  ime, priimek, email, geslo, naslov,id_poste, telefon, status FROM stranke WHERE id_stranke = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetch();
    }
    
    public static function getPredmet($id){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT  ime, cena, status,id_izdelka FROM izdelki WHERE id_izdelka = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->fetch();
    }
    
    public static function dodajZaposlenega($funkcija,$ime,$priimek,$email,$geslo){
        $db = DBInit::getInstance();
        $geslo = password_hash($geslo,PASSWORD_DEFAULT);
        
        
        $statement = $db->prepare("INSERT INTO zaposleni (funkcija, ime,priimek,email,geslo)
            VALUES (:funkcija, :ime,:priimek,:email,:geslo)");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":funkcija", $funkcija);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":geslo", $geslo);
        $statement->execute();
        
    }
    public static function getPosta($id_posta){
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT  naslov FROM posta WHERE posta_id = :id");
        $statement->bindParam(":id", $id_posta);
        $statement->execute();

        return reset($statement->fetch());
        
    }
    
    
    
    
     public static function getIdPosta($posta){
        $db = DBInit::getInstance();
       
        $statement = $db->prepare("SELECT posta_id FROM posta WHERE naslov = :posta");
        $statement->bindParam(":posta", $posta);
        
        
        $statement->execute();
        $id = $statement->fetch();
        if(empty($id)){
            $statement = $db->prepare("INSERT INTO posta (naslov)
            VALUES (:posta)");
            $statement->bindParam(":posta", $posta);
            $statement->execute();
            
            $statement = $db->prepare("SELECT MAX(posta_id) FROM posta WHERE naslov=:posta");
            $statement->bindParam(":posta", $posta);
            $statement->execute();
            $id_pos = $statement->fetch();
            $id_pos = reset($id_pos);
            return $id_pos;
        
        }
        else{
             $id = reset($id);
             return $id;
        }
        
    }
    
    public static function dodajStranko($funkcija,$ime,$priimek,$email,$geslo,$naslov,$posta,$telefon){
        $db = DBInit::getInstance();
        $geslo = password_hash($geslo,PASSWORD_DEFAULT);
        
        $posta = DBTrgovina::getIdPosta($posta);
        $statement = $db->prepare("INSERT INTO stranke ( ime,priimek,email,geslo,naslov,id_poste,telefon)
            VALUES ( :ime,:priimek,:email,:geslo,:naslov,:posta,:telefon)");
        $statement->bindParam(":ime", $ime);
        
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":geslo", $geslo);
        $statement->bindParam(":naslov", $naslov);
        $statement->bindParam(":posta", $posta);        
        $statement->bindParam(":telefon", $telefon);
        $statement->execute();
        
    }
    public static function dodajPredmet($ime,$cena){
        $db = DBInit::getInstance();
        
        
        
        $statement = $db->prepare("INSERT INTO izdelki (ime,cena)
            VALUES ( :ime,:cena)");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":cena", $cena);
       
        $statement->execute();
        
    }
    
    
    public static function updateStranka($id,$ime,$priimek,$email,$geslo,$naslov,$posta,$telefon,$status) {
        $db = DBInit::getInstance();
        #$posta = DBTrgovina::getIdPosta($posta);
        $geslo = password_hash($geslo,PASSWORD_DEFAULT);
        $statement = $db->prepare("UPDATE stranke SET ime=:ime,
            priimek=:priimek, email = :email,geslo=:geslo,naslov=:naslov,id_poste=:posta,telefon=:telefon,status=:status WHERE id_stranke =:id");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":id", $id);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":geslo", $geslo);
        $statement->bindParam(":naslov", $naslov);
         $statement->bindParam(":posta", $posta);
        $statement->bindParam(":telefon", $telefon);
        $statement->bindParam(":status", $status);
        $statement->execute();
    }
    public static function updateZaposleni($id,$ime,$priimek,$email,$geslo,$status) {
        $db = DBInit::getInstance();
         $geslo = password_hash($geslo,PASSWORD_DEFAULT);
        $statement = $db->prepare("UPDATE zaposleni SET ime=:ime,
            priimek=:priimek, email = :email,geslo=:geslo,status = :status WHERE id_zaposleni =:id");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":id", $id);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":geslo", $geslo);
        $statement->bindParam(":status", $status);
        
        $statement->execute();
    }
    
     public static function updatePredmet($id,$ime,$cena,$status){
        $db = DBInit::getInstance();
        
        
        
        $statement = $db->prepare("UPDATE izdelki
            SET  ime = :ime,cena = :cena, status=:status WHERE id_izdelka = :id");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":status", $status);
        $statement->bindParam(":id", $id);
        
        $statement->execute();
        
    }
    public static function spremeniStanjeNarocila($id,$stanje){
        $db = DBInit::getInstance();
        
        
        
        $statement = $db->prepare("UPDATE narocila
            SET  stanje=:stanje WHERE id_narocila = :id");
        
        $statement->bindParam(":id", $id);
        $statement->bindParam(":stanje", $stanje);
        $statement->execute();
        
    }
    
    public static function findIdZaposleni($email){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id_zaposleni FROM zaposleni WHERE email = :email ");
        $statement->bindParam(":email", $email);
        $statement->execute();

        $array = $statement->fetch();
        $first_value = reset($array);
        return strval($first_value);
       
    }
    public static function findIdPredmeta($ime){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id_izdelka FROM izdelki WHERE ime = :ime ");
        $statement->bindParam(":ime", $ime);
        $statement->execute();

        $array = $statement->fetch();
        $first_value = reset($array);
        return strval($first_value);
       
    }
    public static function findIdStranke($email){
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id_stranke FROM stranke WHERE email = :email ");
        $statement->bindParam(":email", $email);
        $statement->execute();

        $array = $statement->fetch();
        $first_value = reset($array);
        return strval($first_value);
       
    }
   
    public static function findIdNarocila($stranka,$datum){
        $db = DBInit::getInstance();
        
        
        $statement = $db->prepare("SELECT id_narocila FROM narocila
            WHERE id_stranke = :stranka AND datum = :datum");
        
        $statement->bindParam(":stranka", $stranka);
        $statement->bindParam(":datum", $datum);
       
        $statement->execute();
        return  $statement->fetch();
    }
    
    public static function izbrisiNarocilo($id){
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("DELETE FROM naroceni_izdelki WHERE id_narocila = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        $statement = $db->prepare("DELETE FROM narocila WHERE id_narocila = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
    
    


    public static function findNarocila($stanje){
        $db = DBInit::getInstance();
        
        
        $statement = $db->prepare("SELECT id_narocila, id_stranke,datum,stanje FROM narocila
            WHERE stanje=:stanje");
        
        $statement->bindParam(":stanje", $stanje);
        
        $statement->execute();
        return  $statement->fetchAll();
    }
    
    public static function preveriPrijavo($vseStranke, $email, $geslo){ //function parameters, two variables.
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
    
    
    
    
    
    
    
    /*
    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM jokes WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
     
     */
    /*
    public static function get($id) {
        // TODO
        // Namig: Ker vračate le en rezultat (in ne vseh) pri vračanju 
        // uporabite funkcijo $statement->fetch(); in ne $statement->fetchAll();
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM jokes WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->fetch();
    }
      */
     

    
    
    // TODO: funkcija za urejanje

}

