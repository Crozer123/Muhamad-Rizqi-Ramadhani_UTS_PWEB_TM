<?php
// PERBAIKAN 1: Nama file adalah 'Product.php' (tanpa 's')
require_once __DIR__ . '/../models/Product.php'; 
require_once __DIR__ . '/../config/database.php';

class ProductService {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $products = [];
        
        // PERBAIKAN 2: Tambahkan 'image_url' secara eksplisit di kueri SELECT
        $result = $this->conn->query("SELECT id, name, description, price, stock, image_url, created_at FROM products ORDER BY created_at DESC");
        
        while ($row = $result->fetch_assoc()) {
            // Buat objek Product
            $product = new Product(
                $row['id'], $row['name'], $row['description'],
                $row['price'], $row['stock'], $row['created_at']
            );
            
            // PERBAIKAN 3: Simpan image_url dari database ke objek
            $product->image_url = $row['image_url'];
            
            $products[] = $product;
        }
        return $products;
    }

    // Fungsi create Anda sudah benar
    public function create($name, $desc, $price, $stock, $image_url) {
        $stmt = $this->conn->prepare(
            'INSERT INTO products (name, description, price, stock, image_url) 
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('ssdis', $name, $desc, $price, $stock, $image_url);
        return $stmt->execute();
    }
}
?>