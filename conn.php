<?php
require_once 'Database.php'; // Pripojenie súboru Database.php. Je zaručené, že súbor bude pripojený iba raz

// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = new Database('localhost', 'root', '', 'kozmetika');
?>
