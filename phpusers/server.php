<?php
if (session_status() == PHP_SESSION_NONE) { // Kontrola začiatku relácie. Ak relácia nebeží, spustí sa
    // Zabezpečuje, aby sa relácia v skripte spustila iba raz, čím predchádza chybám a zabezpečuje správnu správu relácie
    session_start(); // Relácia sa začína
}

// Inicializácia premenných
$username = "";
$email    = "";
$errors = array(); 

// Vytvorí sa nový objekt $db triedy Database na pripojenie k databáze kozmetika. Používateľ root a žiadne heslo
$db = mysqli_connect('localhost', 'root', '', 'kozmetika');

// Registrácia používateľa
if (isset($_POST['reg_user'])) {
    // získať všetky vstupné hodnoty z formulára
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $role = 1; // Predvolená rola pre nových používateľov

    // Overenie formulára (validácia): správne vyplnenie (všetky polia musia byť vyplnené, heslá sa zhodujú)
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // najprv skontrolovať databázu, aby ste sa uistili, či už existuje používateľ s rovnakým menom alebo e-mailom
    $user_check_query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
    $stmt = $db->prepare($user_check_query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) { // Ak už používateľ existuje
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Proces registrácie používateľa, ak vo formulári nie sú žiadne chyby
    if (count($errors) == 0) {
        $password_hashed = password_hash($password_1, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, role) VALUES(?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssi", $username, $email, $password_hashed, $role);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role; // Pridanie roly do relácie
            $_SESSION['success'] = "You are now logged in";
            header('location: ../index.php'); // Uistime sa, že cesta je správna
        } else {
            array_push($errors, "Failed to register user");
        }

        $stmt->close();
    }
}

// Prihlásenie používateľa
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username); // Viazanie parametra pre dotaz
        $stmt->execute();
        $result = $stmt->get_result();

        // Kontrola, či existuje používateľ s daným používateľským menom
        if ($result->num_rows == 1) {
            $logged_in_user = $result->fetch_assoc();
            if (password_verify($password, $logged_in_user['password'])) {
                $_SESSION['username'] = $logged_in_user['username'];
                $_SESSION['email'] = $logged_in_user['email'];
                $_SESSION['role'] = $logged_in_user['role']; // Pridanie roly do relácie
                $_SESSION['success'] = "You are now logged in";
                header('location: ../index.php'); // Uistime sa, že cesta je správna
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }

        $stmt->close();
    }
}

// Kontrola roly používateľa pred vykonaním operácie. Ak požadovaná rola nie je prítomná, pridá sa chyba a dôjde k presmerovaniu na 
// chybovú stránku
function check_role($required_role) {
    global $errors;
    if (!isset($_SESSION['role']) || $_SESSION['role'] < $required_role) {
        array_push($errors, "Insufficient permissions");
        header('location: errors.php'); // Presmerovanie na chybovú stránku
        exit();
    }
}

// Pridanie správy
if (isset($_POST['add_message'])) {
    check_role(1); // Pridávať správy môžu iba registrovaní užívatelia
    $user_id = $_SESSION['user_id'];
    $message = mysqli_real_escape_string($db, $_POST['message']);
    if (empty($message)) {
        array_push($errors, "Message is required");
    }
    if (count($errors) == 0) {
        $query = "INSERT INTO messages (user_id, message) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $user_id, $message);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Message sent successfully";
            header('location: ../index.php');
        } else {
            array_push($errors, "Failed to send message");
        }

        $stmt->close();
    }
}

// Odpoveď administrátora na správu
if (isset($_POST['reply_message'])) {
    check_role(2); // Len administrátori môžu odpovedať na správy
    $message_id = mysqli_real_escape_string($db, $_POST['message_id']);
    $response = mysqli_real_escape_string($db, $_POST['response']);
    if (empty($response)) {
        array_push($errors, "Response is required");
    }
    if (count($errors) == 0) {
        $query = "UPDATE messages SET response=?, updated_at=NOW() WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $response, $message_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Response sent successfully";
            header('location: ../admin/messages.php');
        } else {
            array_push($errors, "Failed to send response");
        }

        $stmt->close();
    }
}
?>
