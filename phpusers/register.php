<?php
require_once '../Database.php';
require_once '../User.php';

$db = new Database('localhost', 'root', '', 'kozmetika');
$user = new User($db);

$errors = [];
$username = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    $user->register($username, $email, $password_1, $password_2);
    $errors = $user->getErrors();
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
        
  <form method="post" action="register.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label for="reg_username">Používateľské meno</label>
      <input type="text" name="username" id="reg_username" value="<?php echo htmlspecialchars($username); ?>">
    </div>
    <div class="input-group">
      <label for="reg_email">E-mail</label>
      <input type="email" name="email" id="reg_email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="input-group">
      <label for="password_1">Hesla</label>
      <input type="password" name="password_1" id="password_1">
    </div>
    <div class="input-group">
      <label for="password_2">Potvrdenie hesla</label>
      <input type="password" name="password_2" id="password_2">
    </div>
    
      <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()">
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
