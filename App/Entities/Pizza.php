<?php
//App/Entities/Pizza.php
namespace App\Entities;

class Pizza
{
    private $pizzaID;
    private $naam;
    private $prijs;
    private $samenstelling;
    private $beschikbaarheid;
    private $promotiePrijs;

    // Setters
    public function setPizzaID($pizzaID)
    {
        $this->pizzaID = $pizzaID;
    }
    public function setNaam($naam)
    {
        $this->naam = $naam;
    }
    public function setPrijs($prijs)
    {
        $this->prijs = $prijs;
    }
    public function setSamenstelling($samenstelling)
    {
        $this->samenstelling = $samenstelling;
    }
    public function setBeschikbaarheid($beschikbaarheid)
    {
        $this->beschikbaarheid = $beschikbaarheid;
    }
    public function setPromotiePrijs($promotiePrijs)
    {
        $this->promotiePrijs = $promotiePrijs;
    }

    // Getters
    public function getPizzaID()
    {
        return $this->pizzaID;
    }
    public function getNaam()
    {
        return $this->naam;
    }
    public function getPrijs()
    {
        return $this->prijs;
    }
    public function getSamenstelling()
    {
        return $this->samenstelling;
    }
    public function getBeschikbaarheid()
    {
        return $this->beschikbaarheid;
    }
    public function getPromotiePrijs()
    {
        return $this->promotiePrijs;
    }
}