<?php
//App/Business/BestellingService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\BestellingDAO;
use App\Entities\Bestelling;

class BestellingService
{
    private $bestellingDAO;

    public function __construct(BestellingDAO $bestellingDAO)
    {
        $this->bestellingDAO = $bestellingDAO;
    }

    public function maakBestellingAan(int $klantId, array $pizzas): void
    {
        $this->bestellingDAO->create($klantId, $pizzas);
    }

    public function haalBestellingOp(int $id): ?Bestelling
    {
        return $this->bestellingDAO->getById($id);
    }
   
}