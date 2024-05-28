<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';

$db = new Database('localhost', 'root', '', 'kozmetika');
$user = new User($db);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];

function check_role($required_role) {
    global $errors;
    if (!isset($_SESSION['role']) || $_SESSION['role'] < $required_role) {
        array_push($errors, "Insufficient permissions");
        header('location: error.php');
        exit();
    }
}

$Meno = '';
$hodnotenia = '';
$text = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Meno = $_POST['Meno'] ?? '';
    $hodnotenia = $_POST['hodnotenia'] ?? '';
    $text = $_POST['text'] ?? '';

    if (isset($_POST['update'])) {
        check_role(2);
        $id = $_POST['id'];
        $query = "UPDATE recenzije SET Meno=?, hodnotenia=?, text=? WHERE id=?";
        if ($db->query($query, [$Meno, $hodnotenia, $text, $id])) {
            header("Location: index.php");
            exit();
        } else {
            // Удаляем сообщение об ошибке
            // echo "Something went wrong. Please try again later. Error: " . $db->getError();
        }
    } else {
        check_role(1);
        $query = "INSERT INTO recenzije (Meno, hodnotenia, text) VALUES (?, ?, ?)";
        if ($db->query($query, [$Meno, $hodnotenia, $text])) {
            header("location: index.php");
            exit();
        } else {
            // Удаляем сообщение об ошибке
            // echo "Something went wrong. Please try again later. Error: " . $db->getError();
        }
    }
} elseif (isset($_GET['id'])) {
    check_role(2);
    $id = $_GET['id'];
    $query = "SELECT * FROM recenzije WHERE id=?";
    $result = $db->query($query, [$id]);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $Meno = $row['Meno'];
        $hodnotenia = $row['hodnotenia'];
        $text = $row['text'];
    } else {
        echo "No record found with that ID.";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Review</h2>
        <form action="adddata.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="Meno">Meno:</label>
                <input type="text" name="Meno" id="Meno" class="form-control" value="<?php echo htmlspecialchars($Meno); ?>" required>
            </div>
            <div class="form-group">
                <label for="hodnotenia">Hodnotenia:</label>
                <select name="hodnotenia" id="hodnotenia" class="form-control" required>
                    <option value="1" <?php if ($hodnotenia == 1) echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($hodnotenia == 2) echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($hodnotenia == 3) echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($hodnotenia == 4) echo 'selected'; ?>>4</option>
                    <option value="5" <?php if ($hodnotenia == 5) echo 'selected'; ?>>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="text">Text:</label>
                <textarea name="text" id="text" class="form-control" required><?php echo htmlspecialchars($text); ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="update" value="Update" class="btn btn-primary">
            </div>
            <a class="nav-link active" href="index.php">obrátiť sa späť</a>
        </form>
    </div>
</body>
</html>
