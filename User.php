<?php
class User { // Deklarácia triedy User
    private $db; 
    private $errors = [];
    private $usernameError = false;
    private $emailError = false;

    public function __construct($db) { 
        // Inicializuje objekt triedy User s odovzdaným databázovým objektom $db Ak relácia nebola spustená, spustí ju
        $this->db = $db;
        // Kontrola, spustenie aktuálneho stavu relácie, relácia je zapnutá, ale ešte nebola spustená. Zaručuje, že relácia bude 
        // spustená iba raz v skripte, čo predchádza chybám a zabezpečuje správnu funkčnosť
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register($username, $email, $password1, $password2) { 
        // Registrácia nového používateľa so zadaným menom, emailom a heslom. Skontroluje chyby zadaných údajov (prázdne polia, nezhoda 
        // hesiel, meno používateľa). Ak nie sú žiadne chyby, zahashuje heslo, uloží nového používateľa do databázy a údaje používateľa do 
        // relácie
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

        if ($this->userExists($username, $email)) {
            if ($this->getUsernameError()) {
                $this->errors[] = "Username already exists";
            }

            if ($this->getEmailError()) {
                $this->errors[] = "Email already exists";
            }
        }

        if (empty($this->errors)) {
            $password = password_hash($password1, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 1)";
            $this->db->query($query, [$username, $email, $password]);

            $user_id = $this->db->getConnection()->insert_id;

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 1;
            $_SESSION['success'] = "You are now logged in";

            header('location: ../index.php');
            exit();
        } else {
            foreach ($this->errors as $error) {
                echo $error . "<br>";
            }
        }
    }

    public function login($username, $password) { 
        // Autorizácia používateľa. Skontroluje zadané údaje, vyhľadá používateľa v databáze a skontroluje zadané heslo s hashom v databáze. 
        // Ak je kontrola úspešná, uloží používateľské údaje do relácie.
        if (empty($username)) {
            $this->errors[] = "Username is required";
        }
        if (empty($password)) {
            $this->errors[] = "Password is required";
        }

        if (empty($this->errors)) {
            $query = "SELECT * FROM users WHERE username=?";
            $stmt = $this->db->query($query, [$username]);

            if ($stmt->num_rows == 1) {
                $user = $stmt->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['success'] = "You are now logged in";

                    header('location: ../index.php');
                    exit();
                } else {
                    $this->errors[] = "Wrong username/password combination";
                }
            } else {
                $this->errors[] = "Wrong username/password combination";
            }
        }

        foreach ($this->errors as $error) {
            echo $error . "<br>";
        }
    }

    public function logout() { 
        // Ukončí reláciu používateľa a presmeruje na domovskú stránku.
        session_destroy();
        header('Location: ../index.php');
        exit();
    }

    public function getErrors() { // Vráti pole chýb nahromadených počas prevádzky
        return $this->errors;
    }

    public function checkRole($required_role) { 
        // Skontroluje aktuálnu rolu používateľa porovnaním s požadovanou rolou. Ak používateľ nemá dostatočné práva, pridá do poľa chybu 
        // a presmeruje sa na chybovú stránku
        if (!isset($_SESSION['role']) || $_SESSION['role'] < $required_role) {
            $this->errors[] = "Insufficient permissions";
            header('location: errors.php');
            exit();
        }
    }

    public function userExists($username, $email) { 
        // Skontroluje, či v databáze existuje používateľ s daným menom alebo e-mailom. Ak sa takýto používateľ nájde, premenná $user bude 
        // obsahovať jeho údaje. Táto metóda sa používa na zabránenie používateľom v registrácii s existujúcim menom alebo e-mailom
        $user_check_query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $stmt = $this->db->query($user_check_query, [$username, $email]);
        $user = $stmt->fetch_assoc();

        if ($user) {
            if ($user['username'] === $username) {
                $this->usernameError = true;
            }

            if ($user['email'] === $email) {
                $this->emailError = true;
            }
            return true;
        }
        return false;
    }

    public function getUsernameError() { 
        // Vráti stav chýb spojených s používateľským menom
        return $this->usernameError; 
    }

    public function getEmailError() { 
        // Vráti stav chýb spojených s používateľským e-mailom
        return $this->emailError;
    }

    public function registerUser($username, $email, $password) { 
        // Proces registrácie nového používateľa v systéme. Hašuje heslo, vkladá údaje používateľa do databázy, nastavuje premenné relácie 
        // pre nového používateľa a hlási úspešnú registráciu

        $password = password_hash($password, PASSWORD_DEFAULT); 
        // Hašuje zadané heslo. Toto sa robí na bezpečné uloženie hesla v databáze

        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 1)"; 
        // SQL dotaz na vloženie nového záznamu do tabuľky používateľov so zadanými poľami. Hodnota 1 - registrovaný používateľ

        $this->db->query($query, [$username, $email, $password]); 
        // Pripravené hodnoty sú odovzdané spolu s požiadavkou na bezpečné vloženie do databázy

        $user_id = $this->db->getConnection()->insert_id; 
        // ID posledného záznamu vloženého do databázovej tabuľky pomocou metódy insert_id

        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 1;
        $_SESSION['success'] = "You are now logged in";

        header('location: ../index.php');
        exit();
    }
}
?>
