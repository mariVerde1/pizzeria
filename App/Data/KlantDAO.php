<?php
//App/Data/KlantDAO.php
namespace App\Data;

use App\Entities\Klant;

use PDO;

class KlantDAO
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getByEmail($email): ?Klant
    {
        $stmt = $this->db->prepare("SELECT * FROM klanten WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $klant = new Klant();
            $klant->setKlantID($row['klantID']);
            $klant->setNaam($row['naam']);
            $klant->setVoornaam($row['voornaam']);
            $klant->setAdres($row['adres']);
            $klant->setPostcode($row['postcode']);
            $klant->setGemeente($row['gemeente']);
            $klant->setGsm($row['gsm']);
            $klant->setEmail($row['email']);
            $klant->setWachtwoord($row['wachtwoord']);
            $klant->setPromotieRecht($row['promotieRecht']);
            return $klant;
        }
        return null;
    }
    public function getById($klantID): ?Klant
    {
    $stmt = $this->db->prepare("SELECT * FROM klanten WHERE klantID = :klantID");
        $stmt->execute([':klantID' => $klantID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $klant = new Klant();
            $klant->setKlantID($row['klantID']);
            $klant->setNaam($row['naam']);
            $klant->setVoornaam($row['voornaam']);
            $klant->setAdres($row['adres']);
            $klant->setPostcode($row['postcode']);
            $klant->setGemeente($row['gemeente']);
            $klant->setGsm($row['gsm']);
            $klant->setEmail($row['email']);
            $klant->setWachtwoord($row['wachtwoord']);
            $klant->setPromotieRecht($row['promotieRecht']);
            return $klant;
        }
        return null;
    }
    public function create(
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
        $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO klanten (naam, voornaam, adres, postcode, gemeente, gsm, email, wachtwoord, promotieRecht)
         VALUES (:naam, :voornaam, :adres, :postcode, :gemeente, :gsm, :email, :wachtwoord, :promotieRecht)"
        );
        $stmt->execute([
            ':naam' => $naam,
            ':voornaam' => $voornaam,
            ':adres' => $adres,
            ':postcode' => $postcode,
            ':gemeente' => $gemeente,
            ':gsm' => $gsm,
            ':email' => $email,
            ':wachtwoord' => $wachtwoordHash,
            ':promotieRecht' => $promotieRecht
        ]);
    }



    public function emailReedsInGebruik($email)
    {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }


    public function getByEmailAndWachtwoord(string $email, string $wachtwoordHash): ?Klant
    {
        $stmt = $this->db->prepare("SELECT * FROM klanten WHERE email = :email AND wachtwoord = :wachtwoord");
        $stmt->execute([':email' => $email, ':wachtwoord' => $wachtwoordHash]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\Entities\Klant");
        return $stmt->fetch() ?: null;
    }
}