<?php
class Database {
    // Konfigurasi database Anda
    private static $host = 'localhost';
    private static $db_name = 'mvc_db';
    private static $username = 'root';
    private static $password = '';
    
    // Properti untuk menyimpan koneksi
    private static $conn = null;

    // Method untuk mendapatkan koneksi database
    public static function getConnection() {
        // Jika koneksi sudah ada, kembalikan koneksi yang lama
        if (self::$conn != null) {
            return self::$conn;
        }
    
        // Jika belum ada, buat koneksi baru
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