<?php
// Kita panggil ProductService untuk mengambil data produk
require_once __DIR__ . '/../service/ProductService.php';

class StoreController {
    
    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Ini adalah halaman utama toko
    public function index() {
        // Ambil semua produk dari database
        $products = $this->productService->getAll();
        
        $data = [
            'products' => $products
        ];

        // Tampilkan halaman view toko
        include __DIR__ . '/../view/Store/index.php';
    }
}
?>