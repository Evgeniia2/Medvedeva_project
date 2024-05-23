<?php
require_once "../conn.php"; // Подключаем файл с параметрами подключения к базе данных

// Выполняем запрос к базе данных для получения всех сообщений
$sql = "SELECT messages.*, users.username FROM messages INNER JOIN users ON messages.user_id = users.id";
$result = $conn->query($sql);

// Обработка формы ответа
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['response']) && isset($_POST['message_id'])) {
    $response = $_POST['response'];
    $message_id = $_POST['message_id'];

    $sql_update_response = "UPDATE messages SET response = ?, updated_at = NOW() WHERE id = ?";
    if ($stmt_update_response = $conn->prepare($sql_update_response)) {
        $stmt_update_response->bind_param("si", $response, $message_id);
        if ($stmt_update_response->execute()) {
            echo "Odpoveď bola úspešne uložená.";
        } else {
            echo "Chyba pri ukladaní odpovede: " . $stmt_update_response->error;
        }
        $stmt_update_response->close();
    } else {
        echo "Chyba pri ukladaní odpovede: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohľad na správy</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <h1>Pohľad na správy</h1>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Message</th>
            <th>Response</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td>" . $row["response"] . "</td>";
                echo '<td>
                        <form method="post" action="">
                            <textarea name="response">' . $row["response"] . '</textarea>
                            <input type="hidden" name="message_id" value="' . $row["id"] . '">
                            <button type="submit">Odpovedať</button>
                        </form>
                      </td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Žiadne správy.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Закрываем соединение с базой данных
$conn->close();
?>
