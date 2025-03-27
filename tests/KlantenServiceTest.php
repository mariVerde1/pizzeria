<?php
namespace Tests;

use App\Business\KlantService;
use App\Data\DBConfig;
use App\Data\KlantDAO;
use App\Entities\Klant;
use PHPUnit\Framework\TestCase;
use \PDO;

class KlantServiceTest extends TestCase
{
    public function testRegistreerKlant()
    {
        $klantDAO = new KlantDAO(new DBConfig());
        $klantService = new KlantService($klantDAO);

        $klant = new Klant();
        $klant->setNaam("Janssen");
        $klant->setVoornaam("Joe");
        $klant->setAdres("Westouterstraat 16");
        $klant->setPostcode("8970");
        $klant->setGemeente("Poperinge");
        $klant->setTelefoon("012345678");
        $klant->setEmail("joe.janssen@example.com");
        $klant->setWachtwoord(md5("wachtwoord123"));
        $klant->setPromotieRecht(true);

        $klantService->registreerKlant();

        $this->assertNotNull($klantDAO->getByEmail("joe.janssen@example.com"));
    }
}