<?php
require_once "conn.php"; // Подключаем файл с параметрами подключения к базе данных
session_start();

$errors = [];

// Инициализируем объект Database
$db = new Database('localhost', 'root', '', 'kozmetika');

// Проверяем, вошел ли пользователь в систему
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        // Получаем данные из сессии
        $username = $_SESSION['username'];
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
        $message = $_POST["message"];

        if (!$email) {
            $errors[] = "Email nie je zadaný v relácii. Prosím, prihláste sa znova.";
        }

        if (empty($errors)) {
            try {
                // Выполняем запрос на получение user_id по username из таблицы users
                $sql_select_user_id = "SELECT id FROM users WHERE username = ?";
                $result = $db->query($sql_select_user_id, [$username]);

                if ($result->num_rows == 1) {
                    // Получаем user_id из результата запроса
                    $row = $result->fetch_assoc();
                    $user_id = $row['id'];

                    // Выполняем запрос на добавление сообщения в базу данных
                    $sql_insert_message = "INSERT INTO messages (user_id, email, message) VALUES (?, ?, ?)";
                    $db->query($sql_insert_message, [$user_id, $email, $message]);

                    // Сообщение успешно добавлено
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

    // Закрываем соединение с базой данных
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
require "templates/footer.php"; // Подключаем подвал сайта
?>
