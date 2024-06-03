<?php
require_once "conn.php"; // Pripojenie súboru conn.php. Je zaručené, že súbor bude pripojený iba raz
session_start();

$errors = [];

// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = new Database('localhost', 'root', '', 'kozmetika');

// Overuje sa, či je aktuálna požiadavka metódou POST. Ak áno, kód vnútri podmienky sa vykoná. Kontroluje sa, či je používateľ 
// prihlásený do systému 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        // Načítavanie údajov z relácie
        $username = $_SESSION['username'];
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
        $message = $_POST["message"];

        if (!$email) {
            $errors[] = "Email nie je zadaný v relácii. Prosím, prihláste sa znova.";
        }

        if (empty($errors)) {
            try {
                // Spustíme dotaz na získanie user_id podľa používateľského mena z tabuľky users
                $sql_select_user_id = "SELECT id FROM users WHERE username = ?";
                $result = $db->query($sql_select_user_id, [$username]);

                if ($result->num_rows == 1) {
                    // Získanie user_id z výsledku dopytu
                    $row = $result->fetch_assoc();
                    $user_id = $row['id'];

                    // Vykonáme požiadavku na pridanie správy do databázy
                    $sql_insert_message = "INSERT INTO messages (user_id, email, message) VALUES (?, ?, ?)";
                    $db->query($sql_insert_message, [$user_id, $email, $message]);

                    // Správa bola úspešne pridaná
                    echo "Vaše správa bola úspešne odoslaná.";
                    header("Location: kontacts.php?status=success");
                    exit();
                } else {
                    $errors[] = "Používateľ s uvedeným menom nebol nájdený.";
                }
            } catch (mysqli_sql_exception $e) {
                $errors[] = "Chyba pri odosielaní správy: " . $db->getError();
            }
        }
    } else {
        $errors[] = "Prosím, prihláste sa, aby ste mohli odoslať správu.";
    }

    // Zatvorenie pripojenia k databáze
    $db->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Odoslanie správy</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="header">
        <h2>Odoslanie správy</h2>
    </div>
    <div class="content">
        <?php if (!empty($errors)) : ?>
            <div class="error">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>Vaša správa bola odoslaná. Ďakujeme za kontaktovanie.</p>
        <?php endif; ?>
        <a href="kontacts.php">Späť na kontakty</a>
    </div>
</body>
</html>

<?php
require "templates/footer.php"; // Pripojenie súboru footer.php (spodná časť stránky). Použitie require znamená, že ak sa súbor nenájde, 
// skript zlyhá.
?>
