<?php
require_once '../Database.php'; // pripojenie súboru Database.php na prácu s databázou
require_once '../User.php';  // pripojenie súboru User.php ktorý obsahuje triedu User pre správu používateľov

$db = new Database('localhost', 'root', '', 'kozmetika'); 
// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo

$user = new User($db); 
// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo

$errors = [];
$username = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  // Overuje sa, či je aktuálna požiadavka metódou POST. Ak áno, kód vnútri podmienky sa vykoná. Kontroluje sa, či je používateľ 
  // prihlásený do systému
    $username = $_POST['username']; // Extrahované údaje z formulára
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    // Zadané údaje sú kontrolované na chyby (prázdne polia, nezhody hesiel)
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // Skontroluje, či už existuje používateľ s rovnakým menom alebo e-mailom
    if ($user->userExists($username, $email)) {
        if ($user->getUsernameError()) {
            array_push($errors, "Username already exists");
        }

        if ($user->getEmailError()) {
            array_push($errors, "Email already exists");
        }
    }

    // Ak sa nenájdu žiadne chyby, zavolá sa metóda registerUser na registráciu nového používateľa do systému
    if (count($errors) == 0) {
        if ($user->registerUser($username, $email, $password_1)) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 1; // Predvolená rola pre nových používateľov
            $_SESSION['success'] = "You are now logged in";
            header('location: ../index.php'); 
        } else {
            array_push($errors, "Failed to register user");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="header">
    <h2>Registrácia</h2>
  </div>
        
  <!-- Odoslanie údajov formulára metódou POST na spracovanie do súboru register.php -->
  <form method="post" action="register.php"> 

    <!-- Vrátane obsahu súboru errors.php v aktuálnom súbore. Užitočné na zobrazenie chýb, ak nejaké existujú -->
    <?php include('errors.php'); ?> 
    <div class="input-group">
      <label for="reg_username">Používateľské meno</label>
      <input type="text" name="username" id="reg_username" value="<?php echo htmlspecialchars($username); ?>">
      <!-- Textové vstupné pole pre používateľské meno. Funkcia htmlspecialchars sa používa na zabránenie útokom XSS -->
    </div>
    <div class="input-group">
      <label for="reg_email">E-mail</label>
      <input type="email" name="email" id="reg_email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="input-group">
      <label for="password_1">Hesla</label>  <!-- Štítok pre prvé pole na zadanie hesla -->
      <input type="password" name="password_1" id="password_1"> <!-- Pole hesla -->
    </div>
    <div class="input-group">
      <label for="password_2">Potvrdenie hesla</label>
      <input type="password" name="password_2" id="password_2"> <!-- Pole na potvrdenie hesla -->
    </div>
    
      <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()"> <!-- JavaScript zobraziť alebo skryť heslo -->
      <label for="show_password">Zobraziť heslo</label>
    
    <div class="input-group">
      <button type="submit" class="btn" name="reg_user">Registrácia</button>
    </div>
    <p>
     Už ste členom? <a href="login.php">Prihlásiť sa</a>
      <a href="../index.php">domovská stránka</a>
    </p>
  </form>
  <script src="../js/script.js"></script>
</body>
</html>
