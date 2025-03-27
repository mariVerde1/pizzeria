<?php
// PizzaController.php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register();

use App\Business\PizzaService;
use App\Business\KlantService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);

$pizzaService = new PizzaService();


if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'home':
            if (isset($_SESSION['klant'])) {
                $klantService = new KlantService();
                $pizzas = $pizzaService->haalAllePizzasOp();
                $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
                echo $twig->render('home.twig', [
                    'pizzas' => $pizzas,
                    'klant' => $_SESSION['klant'],
                    'isIngelogd' => isset($_SESSION['klant'])
                ]);
                exit();
            } else {
                $pizzas = $pizzaService->haalAllePizzasOp();
                echo $twig->render('home.twig', [
                    'pizzas' => $pizzas
                ]);
                exit();

            }


        case 'pizzas':
            $pizzas = $pizzaService->haalAllePizzasOp();
            if (isset($_SESSION['klant'])) {
                $klantService = new KlantService();
                $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
                echo $twig->render('pizzas.twig', [
                    'pizzas' => $pizzas,
                    'klant' => $_SESSION['klant'],
                    'isIngelogd' => isset($_SESSION['klant'])
                ]);
                exit();
            } else {
                echo $twig->render('pizzas.twig', [
                    'pizzas' => $pizzas
                ]);
                exit();

            }



        case 'voegToe':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pizzaId = (int) $_POST['pizzaId'];
                $aantal = (int) $_POST['aantal'];

                if (!isset($_SESSION['winkelmandje'])) {
                    $_SESSION['winkelmandje'] = [];
                }

                if ($aantal > 0) {
                    if (isset($_SESSION['winkelmandje'][$pizzaId])) {
                        $_SESSION['winkelmandje'][$pizzaId] += $aantal;
                    } else {
                        $_SESSION['winkelmandje'][$pizzaId] = $aantal;
                    }
                }

                header('Location: index.php?action=winkelmandje');
                exit();
            }
            break;

        default:
            if (isset($_SESSION['klant'])) {
                $klantService = new KlantService();
                $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
                $pizzas = $pizzaService->haalAllePizzasOp();
                echo $twig->render('home.twig', [
                    'pizzas' => $pizzas,
                    'klant' => $_SESSION['klant'],
                    'isIngelogd' => isset($_SESSION['klant'])
                ]);
                exit();
            } else {
                $pizzas = $pizzaService->haalAllePizzasOp();
                echo $twig->render('home.twig', [
                    'pizzas' => $pizzas
                ]);

                exit();

            }


    }
}