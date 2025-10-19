<?php
class Database {
    private static $host = 'localhost';
    private static $db_name = 'mvc_db';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;
    public static function getConnection() {
        if (self::$conn != null) {
            return self::$conn;
        }
        try {
            self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$db_name);
            if (self::$conn->connect_error) {
                throw new Exception('Koneksi database gagal: ' . self::$conn->connect_error);
            }
            return self::$conn;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
?>
