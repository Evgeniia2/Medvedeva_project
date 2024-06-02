<?php
require_once '../Database.php'; // pripojenie súboru Database.php na prácu s databázou
require_once '../User.php'; // pripojenie súboru User.php ktorý obsahuje triedu User pre správu používateľov

// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = new Database('localhost', 'root', '', 'kozmetika');

// Vytvorí sa nový objekt $user triedy User, ktorý bude slúžiť na vykonávanie operácií s používateľmi.
$user = new User($db);

$user->logout();
?>
