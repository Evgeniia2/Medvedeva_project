<?php
require_once 'Database.php';

$db = new Database('localhost', 'root', '', 'kozmetika');

$id = $_GET["id"];
$query = "DELETE FROM recenzije WHERE id=?";
if ($db->query($query, [$id])) {
    header("location: index.php");
} else {
    echo "Something went wrong. Please try again later.";
}
?>
