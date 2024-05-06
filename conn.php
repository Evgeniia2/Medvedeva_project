<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'kozmetika');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        // Записать ошибку в лог
        error_log("Failed to connect to database: " . mysqli_connect_error());
        die("ERROR: Could not connect to database.");
    }
?>
