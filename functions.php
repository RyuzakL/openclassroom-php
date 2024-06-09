<?php

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Auteur inconnu';
}

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getRecipes(array $recipes): array
{
    $valid_recipes = [];

    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $valid_recipes[] = $recipe;
        }
    }

    return $valid_recipes;
}

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}

function persistUser($value = '') 
{
    setcookie(
        'LOGGED_USER',
        $value,
        [
            'expires' => time() + 365*24*3600,
            'path' => "/",
            'secure' => true,
            'httponly' => true,
        ], 
        
    );
};

function deleteUserCookie()
{
    if(!isset($_COOKIE['LOGGED_USER'])) {
        return;
    }

    setcookie(
        'LOGGED_USER',
        '',
        [
            'expires' => time() - 3600,
            'path' => "/",
            'secure' => true,
            'httponly' => true,
        ], 
        
    );
    unset($_COOKIE['LOGGED_USER']);
}

function destroySession() 
{
    session_unset();
    session_destroy();
}

function clearErrorMessage()
{
 unset($_SESSION['LOGIN_ERROR_MESSAGE']);
}

function setFlashMessage(string $message)
{
    $_SESSION['flash_message'] = $message;
}

function getFlashMessage() : string | null
{
    if (!isset($_SESSION['flash_message'])) {
        return null;        
    }

    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    return $message;
}
