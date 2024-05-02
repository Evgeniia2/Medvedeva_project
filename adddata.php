<?php
    require_once "conn.php"; // Подключаем файл с настройками для соединения с базой данных
    session_start(); // Запускаем сессию

    if (isset($_POST['submit'])) { // Проверяем, была ли нажата кнопка отправки формы

        // Получаем значения из формы
        $Meno = isset($_POST['Meno']) ? $_POST['Meno'] : ''; // Получаем значение поля "Nickname" из формы
        $hodnotenia = isset($_POST['fakulty']) ? $_POST['fakulty'] : ''; // Получаем значение поля "hodnotenia" из формы
        $text = isset($_POST['text']) ? $_POST['text'] : ''; // Получаем значение поля "text" из формы

        // Проверяем, заполнены ли все обязательные поля
        if ($Meno != "" && $hodnotenia != "" && $text != "") {
            // Строим SQL-запрос для добавления данных в базу данных
            $sql = "INSERT INTO recenzije (`Meno`, `hodnotenia`, `text`) VALUES ('$Meno', '$hodnotenia', '$text')";
            // Выполняем SQL-запрос
            if (mysqli_query($conn, $sql)) { // Пытаемся выполнить SQL-запрос
                header("location: index.php"); // Перенаправляем на главную страницу после успешного добавления
                exit(); // Прекращаем выполнение скрипта
            } else {
                echo "Something went wrong. Please try again later."; // Выводим сообщение об ошибке, если запрос не выполнен
            }
        } else {
            echo "Meno, Class, and text cannot be empty!"; // Выводим сообщение, если какое-то из полей не заполнено
        }
    }
?>
