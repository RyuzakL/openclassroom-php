<?php
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

session_start();

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;
$loggedIn = false;


// Validation du formulaire
if (!isset($postData['email']) && !isset($postData['password'])) {
    return; 
}

if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    return;
}   


foreach ($users as $user) {
    
    if (
        $user['email'] === $postData['email'] &&
        $user['password'] === $postData['password']
    ) {
        persistUser($user['email']);
        $loggedIn = true;
        break;
    }
}

if (!$loggedIn) {
    $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
    'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
    $postData['email'],
    strip_tags($postData['password'])
    );
}


redirectToUrl('index.php');
?>