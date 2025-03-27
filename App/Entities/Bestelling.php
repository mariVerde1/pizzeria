<?php
//App/Entities/Bestelling.php
namespace App\Entities;

class Bestelling
{
    private $bestellingID;
    private $klantID;
    private $datumTijd;

    // Setters
    public function setBestellingID($bestellingID)
    {
        $this->bestellingID = $bestellingID;
    }
    public function setKlantID($klantID)
    {
        $this->klantID = $klantID;
    }
    public function setDatumTijd($datumTijd)
    {
        $this->datumTijd = $datumTijd;
    }

    // Getters
    public function getBestellingID()
    {
        return $this->bestellingID;
    }
    public function getKlantID()
    {
        return $this->klantID;
    }
    public function getDatumTijd()
    {
        return $this->datumTijd;
    }
}