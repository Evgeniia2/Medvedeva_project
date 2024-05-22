<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'kozmetika');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $role = 1; // Роль по умолчанию для новых пользователей

  // form validation: ensure that the form is correctly filled ...
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (username, email, password, role) 
                  VALUES('$username', '$email', '$password', '$role')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role; // Добавляем роль в сессию
        $_SESSION['success'] = "You are now logged in";
        header('location: ../index.php'); // Убедимся, что путь верный
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
        array_push($errors, "Username is required");
  }
  if (empty($password)) {
        array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $logged_in_user = mysqli_fetch_assoc($results);
          $_SESSION['username'] = $username;
          $_SESSION['role'] = $logged_in_user['role']; // Добавляем роль в сессию
          $_SESSION['success'] = "You are now logged in";
          header('location: ../index.php'); // Убедимся, что путь верный
        } else {
          array_push($errors, "Wrong username/password combination");
        }
  }
}

// Проверка роли перед выполнением операции
function check_role($required_role) {
    global $errors;
    if (!isset($_SESSION['role']) || $_SESSION['role'] < $required_role) {
        array_push($errors, "Insufficient permissions");
        header('location: error.php'); // Перенаправление на страницу ошибки
        exit();
    }
}

// Пример использования проверки ролей
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_review'])) {
        check_role(1); // Только зарегистрированные пользователи могут добавлять отзывы
        // Код для добавления отзыва
    }

    if (isset($_POST['delete_review'])) {
        check_role(2); // Только администраторы могут удалять отзывы
        // Код для удаления отзыва
    }
}
?>
