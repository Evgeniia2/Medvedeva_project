<?php
require_once "conn.php";
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM recenzije WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $Meno = $row['Meno'];
        $hodnotenia = $row['hodnotenia'];
        $text = $row['text'];
    } else {
        echo "No record found with that ID.";
        exit();
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $Meno = $_POST['Meno'];
    $hodnotenia = $_POST['hodnotenia'];
    $text = $_POST['text'];

    $query = "UPDATE recenzije SET Meno='$Meno', hodnotenia='$hodnotenia', text='$text' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
}

if (isset($_POST['submit'])) {
    $Meno = isset($_POST['Meno']) ? $_POST['Meno'] : '';
    $hodnotenia = isset($_POST['fakulty']) ? $_POST['fakulty'] : '';
    $text = isset($_POST['text']) ? $_POST['text'] : '';

    if ($Meno != "" && $hodnotenia != "" && $text != "") {
        $sql = "INSERT INTO recenzije (`Meno`, `hodnotenia`, `text`) VALUES ('$Meno', '$hodnotenia', '$text')";
        if (mysqli_query($conn, $sql)) {
            header("location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    } else {
        echo "Meno, Class, and text cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($_GET['id']) ? 'Edit Review' : 'Add Review'; ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="header">
        <h2><?php echo isset($_GET['id']) ? 'Edit Review' : 'Add Review'; ?></h2>
    </div>
    
    <form method="post" action="adddata.php">
        <?php if (isset($_GET['id'])): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        <div class="input-group">
            <label>Nickname</label>
            <input type="text" name="Meno" value="<?php echo isset($Meno) ? $Meno : ''; ?>">
        </div>
        <div class="input-group">
            <label>Rating</label>
            <select name="hodnotenia" class="form-control" required>
                <option value="1" <?php if(isset($hodnotenia) && $hodnotenia == '1') echo 'selected'; ?>>1</option>
                <option value="2" <?php if(isset($hodnotenia) && $hodnotenia == '2') echo 'selected'; ?>>2</option>
                <option value="3" <?php if(isset($hodnotenia) && $hodnotenia == '3') echo 'selected'; ?>>3</option>
                <option value="4" <?php if(isset($hodnotenia) && $hodnotenia == '4') echo 'selected'; ?>>4</option>
                <option value="5" <?php if(isset($hodnotenia) && $hodnotenia == '5') echo 'selected'; ?>>5</option>
            </select>
        </div>
        <div class="input-group">
            <label>Review Text</label>
            <textarea name="text"><?php echo isset($text) ? $text : ''; ?></textarea>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="<?php echo isset($_GET['id']) ? 'update' : 'submit'; ?>">
                <?php echo isset($_GET['id']) ? 'Update Review' : 'Add Review'; ?>
            </button>
        </div>
    </form>
</body>
</html>
