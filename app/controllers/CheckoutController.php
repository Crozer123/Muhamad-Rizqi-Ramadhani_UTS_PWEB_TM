<?php
require_once __DIR__ . '/../service/OrderService.php';

class CheckoutController {

    private $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

     // Fungsi untuk menampilkan halaman konfirmasi checkout
    public function index() {
        // Pastikan user login dan bukan admin
        if (!isset($_SESSION['userid']) || $_SESSION['role'] === 'admin') {
            $_SESSION['error'] = 'Anda harus login sebagai user untuk checkout.';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }
        
        // Pastikan keranjang tidak kosong
        $cart_items = $_SESSION['cart'] ?? [];
        if (empty($cart_items)) {
             $_SESSION['error'] = 'Keranjang Anda kosong.';
             header('Location: index.php?c=store&f=index');
             exit;
        }

        $data = ['cart_items' => $cart_items];
        include __DIR__ . '/../view/Checkout/index.php'; // Tampilkan halaman konfirmasi
    }

    // Fungsi untuk memproses checkout (menyimpan ke DB)
    public function process() {
         if (!isset($_SESSION['userid']) || $_SESSION['role'] === 'admin') {
            header('Location: index.php?c=user&f=showLogin'); exit;
         }
         
         $cart_items = $_SESSION['cart'] ?? [];
         $user_id = $_SESSION['userid'];

         if (empty($cart_items)) {
             header('Location: index.php?c=store&f=index'); exit;
         }

         // Panggil OrderService untuk membuat pesanan
         $order_id = $this->orderService->createOrder($user_id, $cart_items);

         if ($order_id) {
             // Jika berhasil, kosongkan keranjang dan tampilkan pesan sukses
             unset($_SESSION['cart']); 
             $_SESSION['success'] = 'Pesanan Anda dengan ID #' . $order_id . ' berhasil dibuat! Terima kasih.';
             header('Location: index.php?c=store&f=index'); // Kembali ke toko
         } else {
             // Jika gagal (error sudah di set di OrderService), kembali ke keranjang
             header('Location: index.php?c=cart&f=viewCart');
         }
         exit;
    }
}
?>