<?php
require_once '../Database.php';
require_once '../User.php';

$db = new Database('localhost', 'root', '', 'kozmetika');
$user = new User($db);

$user->logout();
?>
