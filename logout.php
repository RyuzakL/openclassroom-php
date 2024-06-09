<?php 
session_start();
require_once(__DIR__ . '/functions.php');

if(!isset($_COOKIE['LOGGED_USER'])) {
    return ;
}

setFlashMessage('Vous avez été déconnecté');
deleteUserCookie();
destroySession();
redirectToUrl('index.php')
?>

