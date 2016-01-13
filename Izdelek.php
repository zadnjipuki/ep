<?php

/**
 * Razred Knjiga
 */
class Izdelek {

    /**
     * Naslov knjige
     * @var type String
     */
    

    /**
     * Avtor knjige
     * @var type String
     */
    public $ime = null;

    /**
     * Identifikator knjige
     * @var type int
     */
    public $id = 0;

    /**
     * Cena knjige
     * @var type Double
     */
    public $cena = 0;
    
    public $seznam_slik = array();

    /**
     * Kreira novo instanco s podanim naslovom, avtorjem, 
     * identifikatorjem in ceno.
     * @param type $naslov
     * @param type $avtor
     * @param type $id
     * @param type $cena 
     */
    public function __construct($ime, $id, $cena) {
        $this->ime = $ime;
        
        $this->id = $id;
        $this->cena = $cena;
    }
    

    /**
     * Vrne predstavitev knige v nizu.
     * @return type String
     */
    public function __toString() {
        return $this->ime .  ' ('
                . number_format($this->cena, 2, ',', '.') . ' €)';
    }

}
