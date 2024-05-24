<?php
require_once "conn.php"; // Подключаем файл с параметрами подключения к базе данных
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, вошел ли пользователь в систему
    if (isset($_SESSION['username'])) {
        // Получаем данные из сессии
        $username = $_SESSION['username'];
        // Проверяем наличие ключа 'email' в сессии
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } else {
            // Если ключ 'email' отсутствует, выводим сообщение об ошибке и прекращаем выполнение
            die("Email nie je zadaný v relácii. Prosím, prihláste sa znova.");
        }
        $message = $_POST["message"];

        // Выполняем запрос на получение user_id по username из таблицы users
        $sql_select_user_id = "SELECT id FROM users WHERE username = ?";
        if ($stmt_select_user_id = $conn->prepare($sql_select_user_id)) {
            $stmt_select_user_id->bind_param("s", $username);
            $stmt_select_user_id->execute();
            $result = $stmt_select_user_id->get_result();
            if ($result->num_rows == 1) {
                // Получаем user_id из результата запроса
                $row = $result->fetch_assoc();
                $user_id = $row['id'];

                // Выполняем запрос на добавление сообщения в базу данных
                $sql_insert_message = "INSERT INTO messages (user_id, email, message) VALUES (?, ?, ?)";
                if ($stmt_insert_message = $conn->prepare($sql_insert_message)) {
                    $stmt_insert_message->bind_param("iss", $user_id, $email, $message);
                    if ($stmt_insert_message->execute()) {
                        // Сообщение успешно добавлено
                        echo "Vaše správa bola úspešne odoslaná.";
                    } else {
                        // Ошибка при добавлении сообщения
                        echo "Chyba pri odosielaní správy: " . $stmt_insert_message->error;
                    }
                    $stmt_insert_message->close();
                } else {
                    // Ошибка подготовки запроса
                    echo "Chyba pri odosielaní správy: " . $conn->error;
                }
            } else {
                // Пользователь с указанным username не найден
                echo "Používateľ s uvedeným menom nebol nájdený.";
            }
            $stmt_select_user_id->close();
        } else {
            // Ошибка подготовки запроса
            echo "Chyba pri odosielaní správy: " . $conn->error;
        }
    } else {
        echo "Prosím, prihláste sa, aby ste mohli odoslať správu.";
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>
