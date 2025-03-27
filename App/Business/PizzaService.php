<?php
//App/Business/PizzaService.php
declare(strict_types=1);

namespace App\Business;

use App\Data\PizzaDAO;
use App\Entities\Pizza;

class PizzaService
{

    public function haalAllePizzasOp(): array
    {   $pizzaDAO = new PizzaDAO();
       $lijst = $pizzaDAO->getAll();
        return $lijst;
    }

    public function haalPizzaOp(int $id): ?Pizza
    {   $pizzaDAO = new PizzaDAO();
        return $pizzaDAO->getById($id);
    }
}

