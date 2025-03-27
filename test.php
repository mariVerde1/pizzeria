<?php


//use App\Data\PizzaService;
//test.php
use App\Business\PizzaService;
use App\Data\PizzaDAO;

require_once "./App/business/PizzaService.php";
$ps = new PizzaService();
$service = $ps->haalAllePizzasOp();
print("<pre>");
print_r($service);
print("</pre>");
?>