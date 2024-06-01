<?php
class Database {
    private $conn;

    public function __construct($host, $username, $password, $dbname) {
        $this->conn = new mysqli($host, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);

        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new mysqli_sql_exception($stmt->error);
        }

        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function close() {
        $this->conn->close();
    }

    public function getConnection() {
        return $this->conn;
    }

    // Метод для получения текста ошибки
    public function getError() {
        return $this->conn->error;
    }
}
?>
