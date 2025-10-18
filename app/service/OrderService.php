<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/ProductService.php'; // Kita perlu ini untuk update stok

class OrderService {
    private $conn;
    private $productService;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->productService = new ProductService(); // Inisialisasi ProductService
    }

    public function createOrder($user_id, $cart_items) {
        if (empty($cart_items)) {
            return false; // Tidak bisa checkout keranjang kosong
        }

        $total_amount = 0;
        foreach ($cart_items as $item) {
            $total_amount += $item['price'] * $item['quantity'];
        }

        // Mulai transaksi database (agar aman)
        $this->conn->begin_transaction();

        try {
            // 1. Masukkan ke tabel orders
            $stmt_order = $this->conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
            $stmt_order->bind_param('id', $user_id, $total_amount);
            if (!$stmt_order->execute()) {
                 throw new Exception("Gagal menyimpan order: " . $stmt_order->error);
            }
            $order_id = $this->conn->insert_id; // Dapatkan ID order yang baru saja dibuat
            $stmt_order->close();

            // 2. Masukkan setiap item ke tabel order_items dan kurangi stok
            $stmt_item = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt_update_stock = $this->conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($cart_items as $item) {
                // Masukkan item ke order_items
                $stmt_item->bind_param('iiid', $order_id, $item['id'], $item['quantity'], $item['price']);
                 if (!$stmt_item->execute()) {
                      throw new Exception("Gagal menyimpan order item: " . $stmt_item->error);
                 }

                // Kurangi stok produk
                $stmt_update_stock->bind_param('iii', $item['quantity'], $item['id'], $item['quantity']);
                 if (!$stmt_update_stock->execute() || $stmt_update_stock->affected_rows == 0) {
                     // Jika update gagal (misal stok tiba-tiba habis), batalkan transaksi
                      throw new Exception("Gagal update stok untuk produk ID: " . $item['id'] . ". Stok mungkin tidak cukup.");
                 }
            }
            $stmt_item->close();
            $stmt_update_stock->close();

            // Jika semua berhasil, commit transaksi
            $this->conn->commit();
            return $order_id; // Kembalikan ID order jika sukses

        } catch (Exception $e) {
            // Jika ada error, rollback (batalkan) semua perubahan database
            $this->conn->rollback();
             error_log("Order Error: " . $e->getMessage()); // Catat error (opsional)
            $_SESSION['error'] = "Terjadi kesalahan saat memproses pesanan: " . $e->getMessage();
            return false;
        }
    }
}
?>