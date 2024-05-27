<?php
class User {
    private $db;
    private $errors = [];

    public function __construct($db) {
        $this->db = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register($username, $email, $password1, $password2) {
        if (empty($username)) {
            $this->errors[] = "Username is required";
        }
        if (empty($email)) {
            $this->errors[] = "Email is required";
        }
        if (empty($password1)) {
            $this->errors[] = "Password is required";
        }
        if ($password1 !== $password2) {
            $this->errors[] = "The two passwords do not match";
        }

        $user_check_query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $result = $this->db->query($user_check_query, [$username, $email]);
        $user = $result->fetch_assoc();

        if ($user) {
            if ($user['username'] === $username) {
                $this->errors[] = "Username already exists";
            }

            if ($user['email'] === $email) {
                $this->errors[] = "Email already exists";
            }
        }

        if (empty($this->errors)) {
            $password = password_hash($password1, PASSWORD_DEFAULT); // Используем password_hash вместо md5
            $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 1)";
            $this->db->query($query, [$username, $email, $password]);

            // Получаем ID новосозданного пользователя
            $user_id = $this->db->getConnection()->insert_id;

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 1;
            $_SESSION['success'] = "You are now logged in";

            header('location: ../index.php');
        }
    }

    public function login($username, $password) {
        if (empty($username)) {
            $this->errors[] = "Username is required";
        }
        if (empty($password)) {
            $this->errors[] = "Password is required";
        }

        if (empty($this->errors)) {
            $query = "SELECT * FROM users WHERE username=?";
            $result = $this->db->query($query, [$username]);

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['success'] = "You are now logged in";

                    header('location: ../index.php');
                } else {
                    $this->errors[] = "Wrong username/password combination";
                }
            } else {
                $this->errors[] = "Wrong username/password combination";
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ../index.php');
        exit();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function checkRole($required_role) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] < $required_role) {
            $this->errors[] = "Insufficient permissions";
            header('location: error.php');
            exit();
        }
    }
}
?>
