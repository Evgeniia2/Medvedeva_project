<?php include('templates/header.php'); ?> // Pripájame súbor header.php., jeho obsah je vložený 

<body>
    <section>
        <div class="main-container2">
            <div class="kontacts">
                <h1>Náša kancelária</h1>
                <p><strong>Adresa:</strong> Štefánikova trieda 35/61, 949 01 Nitra</p>

                <table>
                    <tr>
                        <th>Deň</th>
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

                <div class="write-message">
                    <h2>Napíšte nám</h2>
                    <?php if (isset($_SESSION['username'])): ?>  
                        <!-- Kontrola, či je nastavená premenná, teda či je používateľ autorizovaný -->

                        <form method="post" action="send_message.php">  
                            <!-- Ak je používateľ autorizovaný, vytvorí sa formulár, ktorý odošle údaje metódou POST na stránku send_message.php --> 

                            <label for="message">Správa:</label>  
                            <!-- Vytvorí sa štítok pre textovú oblasť, ktorá bude obsahovať správu -->

                            <!-- Pre zadanie správy je vytvorené viacriadkové textové pole, ktoré je potrebné pred odoslaním formulára -->
                            <textarea id="message" name="message" required title="Vyplňte políčko"></textarea>
                            <button type="submit" name="send_message">Odoslať</button>
                        </form>
                    <?php else: ?>  
                        <!-- Prvý, ak sa blok uzatvorí, a začne sa alternatívny blok else, ktorý sa vykoná, ak používateľ nie je autorizovaný -->
                        <p>Prosím, prihláste sa, aby ste mohli odoslať správu.</p>
                    <?php endif; ?>   
                    <!-- Podmienený blok if-else sa zatvorí -->
                </div>

                <div class="row1">
                    <p><strong>čislo:</strong> 0950-712-619</p>
                    <img src="img/pngwing.com.png" alt="telefon" id="icon">
                </div>
                <p><strong>E-mail:</strong> medvedeva@example.com</p>

                <!-- Creative Google map -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.764232775715!2d18.0854231518209!3d48.307385708277074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee307b4e213%3A0xcc86d6ceb39dab2e!2sMlyny!5e0!3m2!1sru!2ssk!4v1702577496218!5m2!1sru!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <?php require "templates/footer.php"; ?> 
    // Pripojenie súboru footer.php (spodná časť stránky). require znamená: ak sa súbor nenájde, skript zlyhá s chybou 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <script src="js/icon.js"></script>
</body>
</html>
