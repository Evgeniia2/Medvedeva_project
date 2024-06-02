<!DOCTYPE html>
<html>
<head>
  <title>Message</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="header">
    <h2>Message</h2>
  </div>
  <form method="post" action="message.php">
    <div class="input-group">
      <label>Meno</label>
      <input type="text" name="name" required>
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="input-group">
      <label>Správa</label>
      <textarea name="message" required></textarea>
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="send_message">Odoslať</button>
    </div>
  </form>
</body>
</html>

<?php
require "templates/footer.php"; // Pripojenie súboru footer.php (spodná časť stránky). require znamená: ak sa súbor nenájde, skript 
// zlyhá s chybou
?>
