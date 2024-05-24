<?php
session_start(); // Добавляем сессию для проверки ролей
require_once "func/functions.php";
?>
<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles-main.css" />
  <link rel="stylesheet" href="css/styles-carousel.css" />
  <link rel="stylesheet" href="css/styles-navbar.css" />
  <link rel="stylesheet" href="css/styles-card.css" />
  <link rel="stylesheet" href="css/styles-kontakts.css">
  <link rel="stylesheet" href="css/styles-recenzie.css">
  <link rel="icon" type="image/x-icon" href="/img/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.1.0/simple-lightbox.min.css">
  
  <title><?php echo 'index | ' . (basename($_SERVER["SCRIPT_NAME"], '.php')); ?></title>
</head>

<body>
  <header>
    <div class="navbar fixed-top">
      <img src="img/logo.png" id="logo" alt="Logo" class="logo">
      <div class="dropmenu">
        <!-- kreative кодом ниже делается изображение (бургер). определенным кодом вставляется определенная картинка -->
        <button class="navbtn">&#9776;</button>
        <div class="navlist">
          <a class="nav-link active" href="index.php">Krémy</a>
          <a class="nav-link" href="Katalog.php">Katalog</a>
          <a class="nav-link" href="recenzie.php">Recenzie</a>
          <a class="nav-link" href="kontacts.php">Kontacts</a>

          <!-- Показывать ссылки на вход и регистрацию только для гостей -->
          <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 0) : ?>
            <a class="login" href="phpusers/login.php">Prihlásit sa</a>
            <a class="nav-link" href="phpusers/register.php">Registrácia</a>
          <?php endif; ?>
          
          <!-- Показывать ссылку на выход только для вошедших пользователей -->
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] > 0) : ?>
            <a class="nav-link" href="phpusers/logout.php">Odhlásenie</a>
          <?php endif; ?>

          <!-- Добавить ссылку для администраторов с ролью 2 -->
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2) : ?>
            <a class="nav-link" href="admin/messages.php">Zobraziť správy</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
</body>
</html>
