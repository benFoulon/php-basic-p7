<?php


use \DateTime;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require __DIR__.'/vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new FilesystemLoader(__DIR__.'/templates');

// instanciation du moteur de template
$twig = new Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension DebugExtension
$twig->addExtension(new DebugExtension());

//traitements des donées

$errors = [];

if ($_POST) {
    $minLength = 3;
    $maxLength = 10;

    if (empty($_POST['login'])) {
        $errors['login'] = 'merci de remplir ce champ';
    } elseif (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 10){
        $errors['login'] = "merci de renseigner un login dont la longueur est comprise entre {$minLength} et {$maxLength}";
    } elseif(preg_match('/[a-zA-z]+$/', $_POST['login']) === 0) { 
        $errors['login'] = "merci de renseigner un login uniquement composé de lettre de l'alphabets sans accent.";
    }

    $date = new DateTime();
    $maxYear = (int) $date->format('Y');
    $minYear = $maxYear - 100;


    if (empty($_POST['year'])) {
        $errors['year'] = 'merci de remplir ce champ';
    } elseif (!is_numeric($_POST['year'])) {
        $errors['year'] = 'merci de remplir ce champ avec une année valide';
    } elseif ((float) $_POST['year'] - (int) $_POST['year'] != 0) {
        $errors['year'] = 'merci de remplir ce champ avec une année valide';
    } elseif ($_POST['year'] <= $minYear || $_POST['year'] >= $maxYear) {
        $errors['year'] = "merci de remplir une année comprise entre {$minYear} et {$maxYear} inclus";
    } 
    

    if (empty($_POST['email'])) {
        $errors['email'] = 'merci de remplir ce champ';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false ){
        $errors['email'] = 'merci de renseigner un email valide'; 
    }
}

// affichage du rendu d'un template
echo $twig->render('form-validation.html.twig', [
    // transmission de données au template
    'errors' => $errors,
]);