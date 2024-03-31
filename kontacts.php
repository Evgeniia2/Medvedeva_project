<?php 
  include "templates/header.php";
  ?>

<body>
  <header>
    <div class="navbar fixed-top">
      <img src="img/logo.png" alt="Logo" class="logo">
      <div class="dropmenu">
        <!-- kreative кодом ниже делается изображение (бургер). так можно вставить хоть телефончик -->
        <button class="navbtn">&#9776;</button>
        <div class="navlist">

          <a class="nav-link" href="index.php">Main</a>
          <a class="nav-link" href="Katalog.php">Katalog</a>
          <a class="nav-link" href="recenzie.php">Recenzie</a>
          <a class="nav-link active" href="kontacts.php">Kontacts</a>
        </div>
      </div>
    </div>
  </header>
  <section>
    <div class="main-container2">
      <div class="kontacts">
        
        <h1>Náša kancelária</h1>

        <p><strong>Adresa:</strong> Štefánikova trieda 35/61, 949 01 Nitra</p>

        <table>
          <tr>
            <th>Deń</th>
            <th>Otváracie hodiny</th>
          </tr>
          <tr>
            <td>Pondelok - Piatok</td>
            <td>9:00 - 18:00</td>
          </tr>
          <tr>
            <td>Sobota</td>
            <td>10:00 - 15:00</td>
          </tr>
          <tr>
            <td>Nedeľa</td>
            <td>Nepracujeme</td>
          </tr>
        </table>
        <div class="row1">

          <p><strong>čislo:</strong> 0950-712-619</p>
          <img src="img/pngwing.com.png" alt="telefon" id="icon"> <!-- creative js animation -->
        </div>
        <p><strong>E-mail:</strong> medvedeva@example.com</p>
        <!-- Creative Google map -->
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.764232775715!2d18.0854231518209!3d48.307385708277074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee307b4e213%3A0xcc86d6ceb39dab2e!2sMlyny!5e0!3m2!1sru!2ssk!4v1702577496218!5m2!1sru!2ssk"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

    </div>
  </section>

  <?php
require "templates/footer.php";
?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
 
  <script src="js/icon.js"></script>
</body>

</html>