<?php
require_once __DIR__ . '/../service/ProductService.php';

class StoreController {
    
    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $products = $this->productService->getAll();
        
        $data = [
            'products' => $products
        ];

        // --- PERBAIKAN: Spasi ekstra dihapus ---
        include __DIR__ . '/../view/Store/index.php'; 
    }
}
?>