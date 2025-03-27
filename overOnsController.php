<?php
//overOnsController.php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register();


use App\Business\KlantService;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/App/Presentation');
$twig = new Environment($loader);

if (isset($_GET["action"]) && ($_GET["action"] === "overOns")) {
    if (isset($_SESSION['klant'])) {
        $klantService = new KlantService();
        $klantInfo = $klantService->getKlantById($_SESSION['klant']['id']);
        echo $twig->render('overOns.twig', [
            'klant' => $_SESSION['klant'],
            'isIngelogd' => isset($_SESSION['klant'])
        ]);
        exit();
    } else {
        echo $twig->render('overOns.twig', []);
        exit();

    }
}