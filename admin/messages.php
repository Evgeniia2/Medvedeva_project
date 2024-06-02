<?php
session_start();
require_once "../conn.php"; // Подключаем файл с параметрами подключения к базе данных

// Проверяем, является ли пользователь администратором
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    echo "Access denied. Only administrators can view this page.";
    exit();
}
// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = new Database('localhost', 'root', '', 'kozmetika');

// Обработка формы ответа
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['response']) && isset($_POST['message_id'])) {
    $response = $_POST['response'];
    $message_id = $_POST['message_id'];

    $sql_update_response = "UPDATE messages SET response = ?, updated_at = NOW() WHERE id = ?";
    try {
        $db->query($sql_update_response, [$response, $message_id]);
        echo "<div class='alert alert-success'>Odpoveď bola úspešne uložená.</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Chyba pri ukladaní odpovede: " . $e->getMessage() . "</div>";
    }
}

// Выполняем запрос к базе данных для получения всех сообщений
$sql = "SELECT messages.*, users.username, users.email FROM messages INNER JOIN users ON messages.user_id = users.id";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohľad na správy</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles-navbar.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <h1 class="mb-4">Pohľad na správy</h1>
        <a class="nav-link" href="../index.php">Vrátiť sa späť</a>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["response"]) . "</td>";
                        echo '<td>
                                <form method="post" action="">
                                    <textarea class="form-control form-control-sm" name="response">' . htmlspecialchars($row["response"]) . '</textarea>
                                    <input type="hidden" name="message_id" value="' . htmlspecialchars($row["id"]) . '">
                                    <button class="btn btn-primary btn-sm mt-3" type="submit">Odpovedať</button>
                                </form>
                              </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Žiadne správy.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Закрываем соединение с базой данных
$db->close();
?>
