<?php
//App/Business/KlantService.php
namespace App\Business;
spl_autoload_register();

use App\Data\KlantDAO;
use App\Entities\Klant;

class KlantService
{



    public function registreerKlant(
        string $naam,
        string $voornaam,
        string $adres,
        string $postcode,
        string $gemeente,
        string $gsm,
        string $email,
        string $wachtwoord,
        bool $promotieRecht
    ): void {
        $klantDAO = new KlantDAO();
        $wachtwoordHash = md5($wachtwoord); 
        $klantDAO->create(
            $naam,
            $voornaam,
            $adres,
            $postcode,
            $gemeente,
            $gsm,
            $email,
            $wachtwoordHash,
            $promotieRecht
        );
    }
    


    public function login(string $email, string $wachtwoord): ?Klant {
        $klantDAO = new KlantDAO();
        $klant = $klantDAO->getByEmail($email);
        
        if ($klant) {
            
            if (md5($wachtwoord) === $klant->getWachtwoord()) {
                
                $_SESSION['klant'] = [
                    'id' => $klant->getKlantID(),
                    'isIngelogd' => true
                ];
                return $klant;
            }
        }
        
        return null;
    }
    public function getKlantById($klantID) {
    $klantDAO = new KlantDAO();
    $klant = $klantDAO->getById($klantID);
    return $klant;
}

    public function isLoggedIn(): bool {
        
        return isset($_SESSION['klant']) && $_SESSION['klant']['isIngelogd'] === true;
    }

    public function controleerGebruiker(string $email, string $wachtwoord): bool
    {
        $klantDAO = new KlantDAO();
        $wachtwoordHash = md5($wachtwoord);
        $klantDAO->getByEmailAndWachtwoord($email, $wachtwoordHash);

        if ($email === "email" && $wachtwoord === "wachtwoord") {
            return true;
        } else {
            return false;
        }
    }
}

