<?php
//loginController.php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

spl_autoload_register();

use App\Business\KlantService;
use App\Business\PizzaService;
use App\Data\PizzaDAO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);
$klantService = new KlantService();

if (isset($_GET["action"]) && ($_GET["action"] === "login")) {
    if (isset($_SESSION['klant'])) {
        $klantService = new KlantService();
        $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
        echo $twig->render('login.twig', [
            'klant' => $_SESSION['klant'],
            'isIngelogd' => isset($_SESSION['klant'])
        ]);
        exit();
    } else {
        echo $twig->render('login.twig', []);
        exit();

    }
}

if (isset($_GET["action"]) && ($_GET["action"] === "registreer")) {
    echo $twig->render('registreren.twig');
}


if (isset($_GET["action"]) && $_GET["action"] === "inloggen") {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $wachtwoord = $_POST['wachtwoord'] ?? '';

        $klant = $klantService->login($email, $wachtwoord);
       
        $isIngelogd = $klantService->isLoggedIn();
        var_dump ($isIngelogd);

        if (isset($_SESSION['klant'])) {
            $klant = $_SESSION['klant'];
            $winkelmandje = $_SESSION['winkelmandje'] ?? [];
            $pizzaService = new PizzaService;
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
                    header('Location: index.php?action=winkelmandje');
                    exit();
                }
            }
        }
    }
}


if (isset($_GET["action"]) && ($_GET["action"] === "registreren")) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $naam = $_POST['naam'];
        $voornaam = $_POST['voornaam'];
        $adres = $_POST['adres'];
        $postcode = $_POST['postcode'];
        $gemeente = $_POST['gemeente'];
        $gsm = $_POST['gsm'];
        $email = $_POST['email'];
        $wachtwoord = $_POST['wachtwoord'];
        $herhaalWachtwoord = $_POST['herhaalWachtwoord'];
        $promotieRecht = isset($_POST['promotieRecht']);

        $klantService->registreerKlant(
            $naam,
            $voornaam,
            $adres,
            $postcode,
            $gemeente,
            $gsm,
            $email,
            $wachtwoord,
            $promotieRecht
        );

       
                $klant = $klantService->login($email, $wachtwoord);
                $_SESSION['klant'] = $klant; 

                if (isset($_SESSION['klant'])) {
                    $klantService = new KlantService();
                    $pizzas = $pizzaService->haalAllePizzasOp();
                    $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
                    echo $twig->render('bestellingOverzicht.twig', [
                        'pizzas' => $pizzas,
                        'klant' => $_SESSION['klant'],
                        'isIngelogd' => isset($_SESSION['klant'])
                    ]);
                    exit();
                } else {
                    header("Location: index.php?action=winkelmandje");
                    exit();
                
                }}} else { 
                    header("Location: index.php?action=registreer&error=login_failed");
                    exit();

                }






        
                /*if ($klant) {
                    $_SESSION['klant'] = $klant; 
                    
                    $_SESSION['winkelmandje'] = $_SESSION['winkelmandje'] ?? []; // Initialize cart if not exists
                    
                    
                    header("Location: index.php?action=winkelmandje");
                    exit();
                } else {
                   
                    header("Location: index.php?action=registreer&error=login_failed");
                    exit();*/
                
        
        
        if (isset($_GET["action"]) && $_GET["action"] === "uitloggen") {
            unset($_SESSION['klant']);
            header("Location: index.php?action=home");
            exit();
        }
        
        
       



