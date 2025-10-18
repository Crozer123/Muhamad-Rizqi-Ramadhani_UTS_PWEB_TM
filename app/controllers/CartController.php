<?php
require_once __DIR__ . '/../service/ProductService.php';

class CartController {

    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Fungsi untuk menambahkan produk ke keranjang
    public function add() {
        // Pastikan user sudah login
        if (!isset($_SESSION['userid'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu untuk membeli.';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }
        
        // Hanya user biasa yang bisa beli, bukan admin
        if ($_SESSION['role'] === 'admin') {
             $_SESSION['error'] = 'Admin tidak bisa melakukan pembelian.';
             header('Location: index.php?c=store&f=index'); // Kembali ke toko
             exit;
        }

        $product_id = $_GET['id'] ?? null;
        $quantity = 1; // Default beli 1

        if (!$product_id) {
            $_SESSION['error'] = 'Produk tidak valid.';
            header('Location: index.php?c=store&f=index');
            exit;
        }

        // Cek apakah produk ada di database
        $product = $this->productService->findById($product_id);
        if (!$product || $product->stock <= 0) {
            $_SESSION['error'] = 'Produk tidak tersedia atau stok habis.';
            header('Location: index.php?c=store&f=index');
            exit;
        }

        // Inisialisasi keranjang jika belum ada di session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Tambah produk ke keranjang atau update quantity jika sudah ada
        if (isset($_SESSION['cart'][$product_id])) {
            // Cek apakah penambahan quantity melebihi stok
            if (($_SESSION['cart'][$product_id]['quantity'] + $quantity) > $product->stock) {
                 $_SESSION['error'] = 'Jumlah melebihi stok yang tersedia untuk produk ' . htmlspecialchars($product->name);
                 header('Location: index.php?c=store&f=index');
                 exit;
            }
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
             if ($quantity > $product->stock) {
                 $_SESSION['error'] = 'Jumlah melebihi stok yang tersedia untuk produk ' . htmlspecialchars($product->name);
                 header('Location: index.php?c=store&f=index');
                 exit;
            }
            $_SESSION['cart'][$product_id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => $quantity
            ];
        }

        $_SESSION['success'] = 'Produk "' . htmlspecialchars($product->name) . '" berhasil ditambahkan ke keranjang!';
        header('Location: index.php?c=store&f=index'); // Kembali ke halaman toko
        exit;
    }
    // Method baru: Menampilkan halaman keranjang belanja
    public function viewCart() {
        // Pastikan user sudah login
        if (!isset($_SESSION['userid'])) {
            $_SESSION['error'] = 'Silakan login untuk melihat keranjang Anda.';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }

        // Ambil data keranjang dari session, atau array kosong jika belum ada
        $cart_items = $_SESSION['cart'] ?? [];
        
        // Kirim data keranjang ke view
        $data = [
            'cart_items' => $cart_items
        ];

        // Muat file view keranjang
        include __DIR__ . '/../view/Cart/index.php'; 
    }

    // Method baru: Menghapus item dari keranjang
    public function remove() {
         if (!isset($_SESSION['userid'])) {
             header('Location: index.php?c=user&f=showLogin'); exit;
         }
         $product_id = $_GET['id'] ?? null;

         if ($product_id && isset($_SESSION['cart'][$product_id])) {
             unset($_SESSION['cart'][$product_id]); // Hapus item dari array session
             $_SESSION['success'] = 'Produk berhasil dihapus dari keranjang.';
         } else {
             $_SESSION['error'] = 'Gagal menghapus produk dari keranjang.';
         }
         header('Location: index.php?c=cart&f=viewCart'); // Kembali ke halaman keranjang
         exit;
    }

     // Method baru: Mengupdate kuantitas item di keranjang
     public function updateQuantity() {
         if (!isset($_SESSION['userid'])) {
             header('Location: index.php?c=user&f=showLogin'); exit;
         }
         
         $product_id = $_POST['id'] ?? null;
         $quantity = $_POST['quantity'] ?? 0;
         
         // Validasi sederhana
         if (!$product_id || !isset($_SESSION['cart'][$product_id]) || !is_numeric($quantity) || $quantity < 1) {
              $_SESSION['error'] = 'Data update tidak valid.';
              header('Location: index.php?c=cart&f=viewCart');
              exit;
         }
         
         // Ambil info produk (untuk cek stok)
         $product = $this->productService->findById($product_id);
         if (!$product) {
              $_SESSION['error'] = 'Produk tidak ditemukan lagi.';
               unset($_SESSION['cart'][$product_id]); // Hapus dari keranjang jika produk hilang
               header('Location: index.php?c=cart&f=viewCart');
               exit;
         }
         
         // Cek apakah kuantitas melebihi stok
         if ($quantity > $product->stock) {
              $_SESSION['error'] = 'Jumlah melebihi stok yang tersedia (' . $product->stock . ') untuk produk ' . htmlspecialchars($product->name);
              // Set kuantitas ke maksimum stok
              $_SESSION['cart'][$product_id]['quantity'] = $product->stock; 
         } else {
              $_SESSION['cart'][$product_id]['quantity'] = (int)$quantity;
               $_SESSION['success'] = 'Kuantitas produk "' . htmlspecialchars($product->name) . '" diperbarui.';
         }

         header('Location: index.php?c=cart&f=viewCart');
         exit;
    }

    // (Nanti kita tambahkan fungsi viewCart, updateCart, removeCart, dll.)
}
?>