<?php
class Database {
    private static $host = 'localhost';  // Remplacez par votre hôte
    private static $dbname = 'projet';  // Remplacez par le nom de votre base
    private static $username = 'root';  // Remplacez par votre utilisateur
    private static $password = '';  // Remplacez par votre mot de passe
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public static function disconnect() {
        self::$connection = null;
    }
}
?>
