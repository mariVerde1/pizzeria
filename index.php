<?php
declare(strict_types=1);


spl_autoload_register();
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);

try {
    $action = $_GET['action'] ?? 'home';

    switch ($action) {
        case 'home':
        case 'pizzas':
        case 'voegToe':
            include __DIR__ . '/PizzaController.php';
            break;

        case 'overOns':
            include __DIR__ . '/overOnsController.php';
            break;

        case 'winkelmandje':
        case 'afrekenen':
        case 'updateAantal':
        case 'verwijder':
        case 'plaatsBestelling':
            include __DIR__ . '/BestellingController.php';
            break;

        case 'bestellingOverzicht':
        case 'login': //loginForm tonen
        case 'registreren': // actie knop 
        case 'registreer': //form tonen
        case 'inloggen': //actie knop
        case 'uitloggen':
            include __DIR__ . '/loginController.php';
            break;

        default:
            http_response_code(404);
            echo $twig->render(htmlentities($_SERVER["PHP_SELF"]));
            exit();
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    echo $twig->render(htmlentities($_SERVER["PHP_SELF"]), ['message' => 'An error occurred']);
}













/*
//index.php
declare(strict_types=1);
spl_autoload_register();

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Business\KlantService;
use App\Business\PizzaService;
use App\Business\BestellingService;
use App\Data\DBConfig;
use App\Data\KlantDAO;
use App\Data\PizzaDAO;
use App\Data\BestellingDAO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Twig initialiseren
$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);

// Haal de actie op uit de URL
$action = $_GET['action'] ?? 'home';
echo "Huidige actie: " . $action;
include __DIR__ . '/PizzaController.php';


// Router-logica
switch ($action) {
    case 'home':
        include 'PizzaController.php';
      
        break;
    case 'pizzas':
        include 'PizzaController.php';
        break;
    case 'over-ons':
        include 'overOnsController.php';
        break;
    case 'winkelmandje':
        include 'BestellingController.php';
        break;
    case 'afrekenen':
        include 'BestellingController.php';
        break;
    case 'registreren':
        include 'KlantController.php';
        break;
    case 'login':
        include 'loginController.php';
        break;
        case 'inloggen':
            include 'loginController.php';
            break;
    case 'voegToe':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pizzaId = (int) $_POST['pizzaId'];
            $aantal = (int) $_POST['aantal'];

            // Voeg de pizza toe aan het winkelmandje in de sessie
            if (!isset($_SESSION['winkelmandje'])) {
                $_SESSION['winkelmandje'] = [];
            }

            if ($aantal > 0) {
                $_SESSION['winkelmandje'][$pizzaId] = $aantal;
            } else {
                unset($_SESSION['winkelmandje'][$pizzaId]);
            }

            header('Location: ?action=winkelmandje');
            exit();
        }
        break;
    case 'ToonWinkelmandje':
        include 'BestellingController.php';
        break;
    case 'updateAantal':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pizzaId = (int) $_POST['pizzaId'];
            $aantal = (int) $_POST['aantal'];

            if ($aantal > 0) {
                $_SESSION['winkelmandje'][$pizzaId] = $aantal;
            } else {
                unset($_SESSION['winkelmandje'][$pizzaId]);
            }

            header('Location: ?action=winkelmandje');
            exit();
        }
        break;

    case 'verwijder':
        if (isset($_GET['id'])) {
            $pizzaId = (int) $_GET['id'];
            unset($_SESSION['winkelmandje'][$pizzaId]);
            header('Location: /winkelmandje');
            exit();
        }
        break;
    default:
        echo "404 - Pagina niet gevonden";
        break;
}*/