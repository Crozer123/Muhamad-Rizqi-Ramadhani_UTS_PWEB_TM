<?php
require_once __DIR__ . '/../models/Product.php'; 
require_once __DIR__ . '/../config/database.php';

class ProductService {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll() {
        $products = [];
        
        $result = $this->conn->query("SELECT id, name, description, price, stock, image_url, created_at FROM products ORDER BY created_at DESC");
        
        while ($row = $result->fetch_assoc()) {
            $product = new Product(
                $row['id'], $row['name'], $row['description'],
                $row['price'], $row['stock'], $row['created_at']
            );
            
            $product->image_url = $row['image_url'];
            
            $products[] = $product;
        }
        return $products;
    }

    public function create($name, $desc, $price, $stock, $image_url) {
        $stmt = $this->conn->prepare(
            'INSERT INTO products (name, description, price, stock, image_url) 
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('ssdis', $name, $desc, $price, $stock, $image_url);
        return $stmt->execute();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, description, price, stock, image_url, created_at FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $product = new Product(
                $row['id'], $row['name'], $row['description'],
                $row['price'], $row['stock'], $row['created_at']
            );
            $product->image_url = $row['image_url'];
            return $product;
        }
        return null;
    }

    public function update($id, $name, $desc, $price, $stock, $image_url) {
        if ($image_url !== null) {
             $stmt = $this->conn->prepare(
                'UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image_url = ? 
                 WHERE id = ?'
             );
             $stmt->bind_param('ssdisi', $name, $desc, $price, $stock, $image_url, $id);
        } else {
             $stmt = $this->conn->prepare(
                'UPDATE products SET name = ?, description = ?, price = ?, stock = ? 
                 WHERE id = ?'
             );
             $stmt->bind_param('ssdis', $name, $desc, $price, $stock, $id);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $product = $this->findById($id);
        if ($product && $product->image_url) {
            $image_path = __DIR__ . '/../../public' . $product->image_url;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>