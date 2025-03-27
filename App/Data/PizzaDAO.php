<?php
//App/Data/PizzaDAO.php
declare(strict_types=1);

namespace App\Data;

use App\Entities\Pizza;
use PDO;

class PizzaDAO
{
    private $db;
   

    public function __construct()
    {
        $this->db = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    }

    public function getAll(): array
    {
        
        $stmt = $this->db->query("SELECT * FROM pizzas");
        return $stmt->fetchAll(PDO::FETCH_CLASS, "App\Entities\Pizza");
    }

    public function getById(int $id): ?Pizza
    {   
        $sql = "SELECT * FROM pizzas WHERE pizzaID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\Entities\Pizza");
        return $stmt->fetch() ?: null;
    }
}