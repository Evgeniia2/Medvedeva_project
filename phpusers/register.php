<?php include('server.php') ?>
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
      <label for="reg_username">Username</label>
      <input type="text" name="username" id="reg_username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
      <label for="reg_email">Email</label>
      <input type="email" name="email" id="reg_email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
      <label for="password_1">Password</label>
      <input type="password" name="password_1" id="password_1">
    </div>
    <div class="input-group">
      <label for="password_2">Confirm password</label>
      <input type="password" name="password_2" id="password_2">
    </div>
    
      <input type="checkbox" id="show_password" onclick="togglePasswordVisibility()">
      <label for="show_password">Zobraziť heslo</label>
    
    <div class="input-group">
      <button type="submit" class="btn" name="reg_user">Registrácia</button>
    </div>
    <p>
      Already a member? <a href="login.php">Prihlásiť sa</a>
      <a href="../index.php">domovská stránka</a>
    </p>
  </form>
  <script src="../js/script.js"></script>
</body>
</html>
