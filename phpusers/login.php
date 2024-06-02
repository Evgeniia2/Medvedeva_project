<?php
if (session_status() == PHP_SESSION_NONE) { 
  // Kontrola začiatku relácie. Ak relácia nebeží, spustí sa. 
  // Zabezpečuje, aby sa relácia v skripte spustila iba raz, čím predchádza chybám a zabezpečuje správnu správu relácie
    session_start(); // Relácia sa začína
}

require_once 'server.php';  // Načítanie súboru server.php

// Definovanie premennej $errors ako prázdne pole na ukladanie chýb
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Bezpečné prijímanie hodnôt z formulára a predchádzanie SQL injekciám
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Kontrola formulára na prázdne hodnoty
    if (empty($username)) { 
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Ak nie sú chyby, pokračuje sa overením používateľa
    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username); // Viazanie parametra pre dotaz
        $stmt->execute();
        $result = $stmt->get_result();

        // Kontrola, či existuje používateľ s daným používateľským menom
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $storedHash = $user['password'];

            if (password_verify($password, $storedHash)) { // Overenie hesla pomocou uloženého hash hodnoty
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = "You are now logged in";

                header('location: ../index.php'); // Pri úspešnom prihlásení sa údaje používateľa uložia do relácie a používateľ je 
                // presmerovaný na hlavnú stránku
                exit();
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>prihlásenie</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="header">
    <h2>prihlásenie</h2>
  </div>
         
  <!-- Odoslanie údajov formulára metódou POST na spracovanie do súboru login.php --> 
  <form method="post" action="login.php">  
    <?php include('errors.php'); ?> 
    <!-- Vkláda sa obsah súboru errors.php v aktuálnom súbore. Užitočné na zobrazenie chýb, ak nejaké existujú -->
    <div class="input-group">
      <label for="login_username">Používateľské meno</label>
      <input type="text" name="username" id="login_username">
    </div>
    <div class="input-group">
      <label for="login_password">Heslo</label>
      <input type="password" name="password" id="login_password">
    </div>
    
    <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()"> <!-- JavaScript zobraziť alebo skryť heslo -->
    <label for="show_password">Zobraziť heslo</label>
    
    <div class="input-group">
      <button type="submit" class="btn" name="login_user">prihlásenie</button>
    </div>
    <p>
      Ešte nie ste členom? <a href="register.php">Zaregistrujte sa</a>
      <a href="../index.php">domovská stránka</a>
    </p>
  </form>
  <script src="../js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
