<?php
use \DateTime;

require __DIR__.'/vendor/autoload.php';

// dump($_POST);

// if ($_POST) {
//     if(empty($_POST['login'])){
//         dump('Le champ login est vide');
//     }

//     if(empty($_POST['year'])){
//         dump('Le champ year est vide');
//     }

//     if(empty($_POST['email'])){
//         dump('Le champ email est vide');
//     }
// }

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


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" novalidate>
        <div>
            <?php if (isset($errors['login'])): ?>
                <?= $errors['login'] ?>
            <?php endif ?>
        </div>
        <div class="">
            <input type="text" name="login" id="" placeholder="login" required>
        </div>
        <div>
            <?php if (isset($errors['year'])): ?>
                <?= $errors['year'] ?>
            <?php endif ?>
        </div>
        <div class="">
            <input type="number" name="year" id="" placeholder="year" required>
        </div>
        <div>
            <?php if (isset($errors['email'])): ?>
                <?= $errors['email'] ?>
            <?php endif ?>
        </div>
        <div class="">
            <input type="email" name="email" id="" placeholder="email" required>
        </div>
        <div class="">
            <button type="submit">Valider</button>
        </div>
    </form>
</body>
</html>