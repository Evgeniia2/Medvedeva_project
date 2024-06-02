<?php
class Database {  // Deklarácia triedy Database
    private $conn;

    public function __construct($host, $username, $password, $dbname) { // Konštruktor triedy, ktorý inicializuje pripojenie k databáze.
        // Možné z ľubovoľného miesta v programe, kde je k dispozícii objekt triedy. Ak dôjde k chybe pripojenia, zobrazí sa chybové hlásenie
        // a vykonávanie skriptu sa zastaví
        $this->conn = new mysqli($host, $username, $password, $dbname); // Pomocou parametrov sa vytvorí nové pripojenie k databáze MySQL

        if ($this->conn->connect_error) { // Kontrola, či sa pri pokuse o pripojenie nevyskytla chyba
            die("Connection failed: " . $this->conn->connect_error);  // Ak sa vyskytne chyba, skript sa ukončí a zobrazí sa chybové hlásenie
        }
    }

    public function query($sql, $params = []) { // Metóda query na vykonanie dotazu SQL s parametrami, ktoré možno volať odkiaľkoľvek, kde 
        // je k dispozícii objekt triedy databázy

        $stmt = $this->conn->prepare($sql); // Volanie metódy Prepare na prípravu a vykonanie SQL dotazu pomocou PDO. Táto metóda chráni 
        // pred injekciami SQL, čo umožňuje bezpečne vkladať parametre do dotazu

        if ($params) {
            $types = str_repeat('s', count($params)); // Vytvorí sa reťazec, ktorý špecifikuje typy parametrov (pre jednoduchosť všetky reťazce 's').
            $stmt->bind_param($types, ...$params); // Metóda naviaže parametre na pripravenú požiadavku pomocou rozbalenia poľa parametrov 
            // Väzba parametrov chráni pred injekciami SQL
        }

        if (!$stmt->execute()) { // Vykoná požiadavku a skontroluje úspešnosť
            throw new mysqli_sql_exception($stmt->error); // Ak spustenie zlyhá, vyvolá sa výnimka s chybovým hlásením
        }

        $result = $stmt->get_result();
        $stmt->close();  // Uzavretie pripraveného dotazu
        return $result;
    }

    public function close() {  // Metóda na ukončenie pripojenia k databáze. Dá sa volať odkiaľkoľvek, kde je dostupný objekt triedy Database
        $this->conn->close();
    }

    public function getConnection() {  // Spôsob získania aktuálneho pripojenia k databáze. Vráti objekt pripojenia.
        return $this->conn;
    }

    // Chybové hlásenie o poslednej operácii databázy
    public function getError() {
        return $this->conn->error;
    }
}
?>
