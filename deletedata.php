<?php
require_once 'Database.php'; // Pripojenie súboru Database.php. Je zaručené, že súbor bude pripojený iba raz

// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = new Database('localhost', 'root', '', 'kozmetika');

$id = $_GET["id"]; // Získanie hodnoty parametra id z požiadavky GET a jej priradenie k premennej $id
$query = "DELETE FROM recenzije WHERE id=?"; // SQL dotaz na odstránenie záznamu z tabuľky recenzije

// Vykonanie prípraveného dotazu v prípade úspechu
if ($db->query($query, [$id])) { 
    header("location: index.php"); // Presmerovanie používateľa na domovskú stránku
} else {
    echo "Something went wrong. Please try again later."; // chybové hlásenie, operácia zlyhala
}
?>
