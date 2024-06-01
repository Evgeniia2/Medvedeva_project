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
        $query = "SELECT * FROM users WHERE username=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $storedHash = $user['password'];

            if (password_verify($password, $storedHash)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = "You are now logged in";

                header('location: ../index.php');
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
         
  <form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label for="login_username">Používateľské meno</label>
      <input type="text" name="username" id="login_username">
    </div>
    <div class="input-group">
      <label for="login_password">Heslo</label>
      <input type="password" name="password" id="login_password">
    </div>
    
    <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()">
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
