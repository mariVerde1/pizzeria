<?php
//App/Data/BestellingDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Bestelling;
use PDO;

class BestellingDAO
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function create(int $klantId, array $pizzas): void
    {
        $this->db->beginTransaction();
        try {
            // Voeg de bestelling toe
            $stmt = $this->db->prepare(
                "INSERT INTO bestellingen (klantID, datumTijd) VALUES (:klantId, NOW())"
            );
            $stmt->execute([':klantId' => $klantId]);
            $bestellingId = $this->db->lastInsertId();
    
            // Voeg de bestellingslijnen toe
            foreach ($pizzas as $pizza) {
                if (!isset($pizza['id'], $pizza['aantal'], $pizza['prijs'])) {
                    throw new \InvalidArgumentException("Ongeldige pizza-data");
                }
    
                $stmt = $this->db->prepare(
                    "INSERT INTO bestellingLijnen (bestellingID, pizzaID, aantal, prijsPerStuk) 
                     VALUES (:bestellingId, :pizzaId, :aantal, :prijsPerStuk)"
                );
                $stmt->execute([
                    ':bestellingId' => $bestellingId,
                    ':pizzaId' => $pizza['id'],
                    ':aantal' => $pizza['aantal'],
                    ':prijsPerStuk' => $pizza['prijs']
                ]);
            }
    
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getById(int $id): ?Bestelling
    {
        $stmt = $this->db->prepare("SELECT * FROM bestellingen WHERE bestellingID = :id");
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\Entities\Bestelling");
        return $stmt->fetch() ?: null;
    }
}