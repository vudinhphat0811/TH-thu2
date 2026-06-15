<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    // 🌟 Trang hiển thị danh sách toàn bộ danh mục giống quản lý sản phẩm
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Hàm hiển thị giao diện thêm danh mục mới
    public function add()
    {
        include_once 'app/views/category/add.php';
    }

    // Hàm tiếp nhận dữ liệu từ Form và tiến hành lưu
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->addCategory($name, $description);

            if (is_array($result)) {
                $errors = $result;
                include 'app/views/category/add.php';
            } else {
                // ĐÃ SỬA: Bỏ /webbanhang
                header('Location: /Category/list');
            }
        }
    }
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            // ĐÃ SỬA: Bỏ /webbanhang
            header('Location: /Category/list');
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
}
?>