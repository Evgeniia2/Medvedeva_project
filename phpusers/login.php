<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'server.php';

// Определяем переменную $errors
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $logged_in_user = mysqli_fetch_assoc($results);
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $logged_in_user['email']; // Добавляем email в сессию
            $_SESSION['role'] = $logged_in_user['role'];
            $_SESSION['success'] = "You are now logged in";
            header('location: ../index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
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
         
  <form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label for="login_username">Username</label>
      <input type="text" name="username" id="login_username">
    </div>
    <div class="input-group">
      <label for="login_password">Password</label>
      <input type="password" name="password" id="login_password">
    </div>
    
    <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()">
    <label for="show_password">Zobraziť heslo</label>
    
    <div class="input-group">
      <button type="submit" class="btn" name="login_user">prihlásenie</button>
    </div>
    <p>
      Not yet a member? <a href="register.php">Sign up</a>
      <a href="../index.php">domovská stránka</a>
    </p>
  </form>
  <script src="../js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
