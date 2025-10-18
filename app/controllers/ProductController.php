<?php
// Pastikan path ini benar dan file service-nya ada
require_once __DIR__ . '/../service/ProductService.php';

class ProductController {
    
    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkLogin() {
        if (!isset($_SESSION['userid'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu!';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }
         // Cek keamanan tambahan, hanya admin yang boleh akses
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Hanya admin yang bisa mengakses halaman ini!';
            header('Location: index.php?c=store&f=index'); // Lempar ke toko
            exit;
        }
    }

    // Menampilkan halaman daftar produk
    public function showList() {
        $this->checkLogin();
        $products = $this->productService->getAll();
        $data = [
            'products' => $products
        ];
        
        // --- INI PERBAIKANNYA (Menambahkan 'view/') ---
        include __DIR__ . '/../view/Product/list.php';
    }

    // Menampilkan form tambah produk
    public function showAddForm() {
        $this->checkLogin();
        
        // --- INI PERBAIKANNYA (Menambahkan 'view/') ---
        include __DIR__ . '/../view/Product/add.php';
    }

    // Memproses data dari form tambah produk
    public function add() {
        $this->checkLogin();
        
        $name = $_POST['name'] ?? '';
        $desc = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $image_url = null; // Default jika tidak ada gambar

        if (empty($name) || $price <= 0) {
            $_SESSION['error'] = 'Nama produk dan harga harus diisi!';
            header('Location: index.php?c=product&f=showAddForm');
            exit;
        }

        // === LOGIKA UPLOAD GAMBAR ===
        try {
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                
                $target_dir = __DIR__ . '/../../public/uploads/'; // Path ke folder public/uploads/
                $image_file_type = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
                
                // Buat nama file unik (untuk menghindari tumpang tindih)
                $new_filename = uniqid('prod_', true) . '.' . $image_file_type;
                $target_file = $target_dir . $new_filename;

                // Cek apakah file adalah gambar
                $check = getimagesize($_FILES['product_image']['tmp_name']);
                if ($check === false) {
                    throw new Exception('File bukan gambar.');
                }

                // Cek ekstensi file
                if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") {
                    throw new Exception('Maaf, hanya file JPG, JPEG, & PNG yang diizinkan.');
                }

                // Pindahkan file dari temp ke folder uploads
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
                    // Simpan path relatif ke database
                    $image_url = '/uploads/' . $new_filename;
                } else {
                    throw new Exception('Maaf, terjadi error saat meng-upload file.');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?c=product&f=showAddForm');
            exit;
        }
        // === AKHIR LOGIKA UPLOAD ===

        // Masukkan ke database (sekarang dengan $image_url)
        $success = $this->productService->create($name, $desc, $price, $stock, $image_url);

        if ($success) {
            $_SESSION['success'] = 'Produk baru berhasil ditambahkan!';
            header('Location: index.php?c=product&f=showList');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan produk ke database!';
            header('Location: index.php?c=product&f=showAddForm');
        }
        exit;
    }
}
?>