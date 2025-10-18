<?php
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
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Hanya admin yang bisa mengakses halaman ini!';
            header('Location: index.php?c=store&f=index'); 
            exit;
        }
    }

    public function showList() {
        $this->checkLogin();
        $products = $this->productService->getAll();
        $data = [
            'products' => $products
        ];
        
        include __DIR__ . '/../view/Product/list.php';
    }

    public function showAddForm() {
        $this->checkLogin();
        
        include __DIR__ . '/../view/Product/add.php';
    }

    public function add() {
        $this->checkLogin();

    $name = $_POST['name'] ?? '';
    $desc = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $image_url = null; 

    if (empty($name) || $price <= 0) {
        $_SESSION['error'] = 'Nama produk dan harga harus diisi!';
        header('Location: index.php?c=product&f=showAddForm');
        exit;
    }

    try {
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {

            $target_dir = __DIR__ . '/../../public/uploads/'; 
            $image_file_type = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));

            $new_filename = uniqid('prod_', true) . '.' . $image_file_type;
            $target_file = $target_dir . $new_filename;

            $check = getimagesize($_FILES['product_image']['tmp_name']);
            if ($check === false) {
                throw new Exception('File bukan gambar.');
            }

            if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") {
                throw new Exception('Maaf, hanya file JPG, JPEG, & PNG yang diizinkan.');
            }

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
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
    // Method baru: Menampilkan form edit
    public function showEditForm() {
        $this->checkLogin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'ID produk tidak valid.';
            header('Location: index.php?c=product&f=showList');
            exit;
        }

        $product = $this->productService->findById($id);
        if (!$product) {
            $_SESSION['error'] = 'Produk tidak ditemukan.';
            header('Location: index.php?c=product&f=showList');
            exit;
        }

        $data = ['product' => $product];
        include __DIR__ . '/../view/Product/edit.php'; // Load view edit
    }

    // Method baru: Memproses update produk
    public function update() {
        $this->checkLogin();
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $desc = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $image_url = null; // Default, akan diisi jika ada upload baru

        if (!$id || empty($name) || $price <= 0) {
            $_SESSION['error'] = 'Data tidak lengkap atau tidak valid.';
            // Redirect kembali ke form edit jika ID ada, jika tidak ke list
            header('Location: index.php?c=product&f=' . ($id ? 'showEditForm&id=' . $id : 'showList'));
            exit;
        }

        // Logika upload gambar (sama seperti di add(), tapi opsional)
        try {
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                
                // (Anda bisa menyalin logika upload dari fungsi add() ke sini)
                // Pastikan untuk menghapus gambar lama jika ada upload baru
                $oldProduct = $this->productService->findById($id);
                if ($oldProduct && $oldProduct->image_url) {
                    $old_image_path = __DIR__ . '/../../public' . $oldProduct->image_url;
                    if (file_exists($old_image_path)) {
                        @unlink($old_image_path);
                    }
                }
                
                $target_dir = __DIR__ . '/../../public/uploads/'; 
                $image_file_type = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
                $new_filename = uniqid('prod_', true) . '.' . $image_file_type;
                $target_file = $target_dir . $new_filename;

                $check = getimagesize($_FILES['product_image']['tmp_name']);
                if ($check === false) throw new Exception('File bukan gambar.');
                if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") throw new Exception('Hanya JPG, JPEG, PNG.');

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
                    $image_url = '/uploads/' . $new_filename;
                } else {
                    throw new Exception('Gagal meng-upload file baru.');
                }
            }
            // Jika tidak ada upload baru, $image_url akan tetap null
            // dan ProductService->update tidak akan mengubah kolom image_url

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?c=product&f=showEditForm&id=' . $id);
            exit;
        }

        // Panggil service update
        $success = $this->productService->update($id, $name, $desc, $price, $stock, $image_url);

        if ($success) {
            $_SESSION['success'] = 'Produk berhasil diperbarui!';
            header('Location: index.php?c=product&f=showList');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui produk di database!';
            header('Location: index.php?c=product&f=showEditForm&id=' . $id);
        }
        exit;
    }

    // Method baru: Memproses hapus produk
    public function delete() {
        $this->checkLogin();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'ID produk tidak valid.';
            header('Location: index.php?c=product&f=showList');
            exit;
        }
        
        $success = $this->productService->delete($id);

        if ($success) {
            $_SESSION['success'] = 'Produk berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus produk!';
        }
        header('Location: index.php?c=product&f=showList');
        exit;
    }
}
?>
