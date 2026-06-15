<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/AuthHelper.php'); // Đảm bảo nhúng AuthHelper hệ thống

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        
        // Đvector ĐÃ KHẮC PHỤC: Không chặn Admin ở đây nữa để tránh đá User thường khi vào trang shop
    }

    // ==========================================================
    // 🛠️ PHÂN HỆ QUẢN TRỊ (Chỉ tài khoản ADMIN mới được phép truy cập)
    // ==========================================================

    public function index()
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới cho xem danh sách kho hàng
        AuthHelper::requireAdmin($this->db);
        
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function add()
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới cho vào trang thêm
        AuthHelper::requireAdmin($this->db);
        
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới được lưu dữ liệu
        AuthHelper::requireAdmin($this->db);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /Product');
            }
        }
    }

    public function edit($id)
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới cho sửa
        AuthHelper::requireAdmin($this->db);
        
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới được cập nhật
        AuthHelper::requireAdmin($this->db);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        // Kiểm tra nghiêm ngặt: Quyền ADMIN mới được xóa
        AuthHelper::requireAdmin($this->db);
        
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }


    // ==========================================================
    // 🛒 PHÂN HỆ MUA SẮM (Cả tài khoản USER thường và ADMIN đều dùng được)
    // ==========================================================

    public function shop() 
    {
        // Chỉ cần tài khoản đã đăng nhập thành viên là được phép mua sắm
        AuthHelper::requireLogin($this->db);
        
        $searchTerm = $_GET['search'] ?? '';
        $searchTerm = trim($searchTerm);
        
        $categoryId = $_GET['category_id'] ?? '';
        $categoryId = trim($categoryId);
    
        if ($searchTerm !== '' || $categoryId !== '') {
            $products = $this->productModel->searchAndFilterProducts($searchTerm, $categoryId);
        } else {
            $products = $this->productModel->getProducts();
        }
    
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/shop.php';
    }

    public function show($id)
    {
        // Chỉ cần đăng nhập thành viên là được xem chi tiết cấu hình sản phẩm
        AuthHelper::requireLogin($this->db);
        
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function addToCart($id)
    {
        AuthHelper::requireLogin($this->db);
        
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /Product/cart');
    }

    public function cart()
    {
        AuthHelper::requireLogin($this->db);
        
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function checkout()
    {
        AuthHelper::requireLogin($this->db);
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        AuthHelper::requireLogin($this->db);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }
            
            $this->db->beginTransaction();
            try {
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }
                
                unset($_SESSION['cart']);
                $this->db->commit();
                header('Location: /Product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation()
    {
        AuthHelper::requireLogin($this->db);
        include 'app/views/product/orderConfirmation.php';
    }

    public function increaseCart($id)
    {
        AuthHelper::requireLogin($this->db);
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        header('Location: /Product/cart');
    }

    public function decreaseCart($id)
    {
        AuthHelper::requireLogin($this->db);
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']--;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: /Product/cart');
    }

    public function buyNow($id)
    {
        AuthHelper::requireLogin($this->db);
        
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /Product/checkout');
    }

    // Hàm bổ trợ tải lên hình ảnh dạng nội bộ
    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }
}
?>