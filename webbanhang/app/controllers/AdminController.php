<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';
require_once 'app/helpers/AuthHelper.php';

class AdminController {
    private $userModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
        // Bảo vệ nghiêm ngặt: Chỉ Admin mới chạy được các hàm dưới đây
        AuthHelper::requireAdmin($this->db);
    }

    public function users() {
        $users = $this->userModel->getAllUsers();
        include 'app/views/admin/users.php';
    }

    public function toggleStatus($id) {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            $newStatus = ($user->status === 'active') ? 'locked' : 'active';
            $this->userModel->updateStatus($id, $newStatus);
        }
        header('Location: /Admin/users');
        exit();
    }
    
    // Hàm xử lý thay đổi vai trò (Set Admin / User)
public function changeRole($id) {
    // Lấy thông tin user hiện tại từ database
    $user = $this->userModel->getUserById($id);
    
    if ($user) {
        // Nếu đang là user thì đổi thành admin, và ngược lại
        $newRole = ($user->role === 'user') ? 'admin' : 'user';
        
        // Sử dụng luôn hàm updateToken hoặc viết câu lệnh SQL nhanh để cập nhật vai trò
        $query = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':role' => $newRole, ':id' => $id]);
    }
    
    // Sau khi đổi xong, tự động load lại trang quản lý người dùng
    header('Location: /Admin/users');
    exit();
}
}