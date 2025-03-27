<?php
//App/Entities/Klant.php
namespace App\Entities;
use App\Exceptions\OngeldigEmailException;
use App\Exceptions\WachtwoordenKomenNietOvereenException;

class Klant
{
    private $klantID;
    private $naam;
    private $voornaam;
    private $adres;
    private $postcode;
    private $gemeente;
    private $gsm;
    private $email;
    private $wachtwoord;
    private $promotieRecht;

    // Setters
    public function setKlantID($klantID)
    {
        $this->klantID = $klantID;
    }
    public function setNaam($naam)
    {
        $this->naam = $naam;
    }
    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;
    }
    public function setAdres($adres)
    {
        $this->adres = $adres;
    }
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }
    public function setGemeente($gemeente)
    {
        $this->gemeente = $gemeente;
    }
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;
    }
    public function setEmail($email)
    {
 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {         throw new OngeldigEmailException(); 
            } 
            $this->email = $email; 
        
    }
    public function setWachtwoord($wachtwoord) 
    {    
        
       $this->wachtwoord = $wachtwoord;
    }
    
    public function setPromotieRecht($promotieRecht)
    {
        $this->promotieRecht = $promotieRecht;
    }

    // Getters
    public function getKlantID()
    {
        return $this->klantID;
    }
    public function getNaam()
    {
        return $this->naam;
    }
    public function getVoornaam()
    {
        return $this->voornaam;
    }
    public function getAdres()
    {
        return $this->adres;
    }
    public function getPostcode()
    {
        return $this->postcode;
    }
    public function getGemeente()
    {
        return $this->gemeente;
    }
    public function getGsm()
    {
        return $this->gsm;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getWachtwoord()
    {
        return $this->wachtwoord;
    }
    public function getPromotieRecht()
    {
        return $this->promotieRecht;
    }
}