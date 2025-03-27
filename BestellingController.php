<?php
// bestellingController.php
declare(strict_types=1);

use App\Data\PizzaDAO;
spl_autoload_register();
require_once __DIR__ . '/vendor/autoload.php';

use App\Business\BestellingService;
use App\Business\PizzaService;
use App\Business\KlantService;
use App\Data\BestellingDAO;
use App\Data\KlantDAO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);

$bestellingService = new BestellingService(new BestellingDAO());
$pizzaService = new PizzaService();
$klantService = new KlantService();

if (isset($_GET["action"]) && ($_GET["action"] === "afrekenen")) {
    // Controleer of klant is ingelogd

    if (isset($_SESSION['klant'])) {
        $klant = $_SESSION['klant'];
        $winkelmandje = $_SESSION['winkelmandje'] ?? [];
        $pizzas = $pizzaService->haalAllePizzasOp();
        $winkelmandjeInhoud = [];
        $totaal = 0;

        foreach ($klant as $klantId) {
            $klant = $klantService->getKlantById($klantId);
            if ($klant) {
                $info[] = [
                    'id' => $klant->getKlantID(),
                    'naam' => $klant->getNaam(),
                    'voornaam' => $klant->getVoornaam(),
                    'adres' => $klant->getAdres(),
                    'postcode' => $klant->getPostcode(),
                    'gemeente' => $klant->getGemeente(),
                    'gsm' => $klant->getGsm(),
                    'email' => $klant->getEmail(),

                ];

                foreach ($winkelmandje as $pizzaId => $aantal) {
                    $pizza = $pizzaService->haalPizzaOp($pizzaId);
                    if ($pizza) {
                        $winkelmandjeInhoud[] = [
                            'id' => $pizza->getPizzaID(),
                            'naam' => $pizza->getNaam(),
                            'prijs' => $pizza->getPrijs(),
                            'aantal' => $aantal
                        ];
                        $totaal += $pizza->getPrijs() * $aantal;
                    }
                }

                echo $twig->render('bestellingOverzicht.twig', [
                    'klant' => $klant,
                    'winkelmandje' => $winkelmandjeInhoud,
                    'totaal' => $totaal,
                    'isIngelogd' => isset($_SESSION['klant'])
                ]);
            } else {
                header('Location: ?action=winkelmandje');
                exit();
            }
        }
    }
}


if (isset($_GET["action"]) && ($_GET["action"] === "verwijder")) {

    $pizzaId = (int) $_GET["id"];
    if (isset($_SESSION['winkelmandje'][$pizzaId])) {
        unset($_SESSION['winkelmandje'][$pizzaId]);
    }
    header('Location: ?action=winkelmandje');
    exit();
}


if (isset($_GET["action"]) && ($_GET["action"] === "updateAantal")) {

    $pizzaId = (int) $_GET["id"];
    if (isset($_SESSION['winkelmandje'][$pizzaId])) {

    }

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
}

if (isset($_GET["action"]) && ($_GET["action"] === "winkelmandje")) {
    $winkelmandje = $_SESSION['winkelmandje'] ?? [];
    $winkelmandjeInhoud = [];
    $totaal = 0;

    foreach ($winkelmandje as $pizzaId => $aantal) {
        $pizza = $pizzaService->haalPizzaOp($pizzaId);
        if ($pizza) {
            $winkelmandjeInhoud[] = [
                'id' => $pizza->getPizzaID(),
                'naam' => $pizza->getNaam(),
                'prijs' => $pizza->getPrijs(),
                'aantal' => $aantal
            ];
            $totaal += $pizza->getPrijs() * $aantal;
        }
    }

    echo $twig->render('winkelmandje.twig', [
        'winkelmandje' => $winkelmandjeInhoud,
        'totaal' => $totaal,
        'isIngelogd' => isset($_SESSION['klant'])
    ]);
   

} 




if (isset($_POST["action"]) && ($_POST["action"] === "plaatsBestelling")) {
    

    if (!isset($_SESSION['klant']) || !$_SESSION['klant']->isIngelogd()) {
        header('Location: index.php?action=login');
        exit();
    }


    if (!isset($_SESSION['winkelmandje']) || empty($_SESSION['winkelmandje'])) {
        header('Location: index.php?action=pizzas');
        exit();
    }


    $winkelmandje = $_SESSION['winkelmandje'] ?? [];
    if (isset($_SESSION['klant'])) {

        $klant = $_SESSION['klant']->getKlantID();

        foreach ($klant as $klantId) {
            $klant = $klantService->getKlantById($klantId);
            if ($klant) {
                $info[] = [
                    'id' => $klant->getKlantID(),
                    'naam' => $klant->getNaam(),
                    'voornaam' => $klant->getVoornaam(),
                    'adres' => $klant->getAdres(),
                    'postcode' => $klant->getPostcode(),
                    'gemeente' => $klant->getGemeente(),
                    'gsm' => $klant->getGsm(),
                    'email' => $klant->getEmail(),

                ];
            }
            var_dump($klant);
            $winkelmandje = $_SESSION['winkelmandje'] ?? [];
            $pizzas = $pizzaService->haalAllePizzasOp();
            $winkelmandjeInhoud = [];
            $totaal = 0;

            foreach ($winkelmandje as $pizzaId => $aantal) {
                $pizza = $pizzaService->haalPizzaOp($pizzaId);
                if ($pizza) {
                    $winkelmandjeInhoud[] = [
                        'id' => $pizza->getPizzaID(),
                        'naam' => $pizza->getNaam(),
                        'prijs' => $pizza->getPrijs(),
                        'aantal' => $aantal
                    ];
                    $totaal += $pizza->getPrijs() * $aantal;
                }
            }

            //$bestellingId = $bestellingService->maakBestellingAan($klantId, $pizzas);


            unset($_SESSION['winkelmandje']);

            // Toon bevestiging
            echo $twig->render('bestellingBevestiging.twig', [
                'klant' => $_SESSION['klant'],
                'bestelling' => $pizzas,
                'bestellingId' => $bestellingId,
                'isIngelogd' => isset($_SESSION['klant'])
            ]);

            exit();
        }
    }
}

























