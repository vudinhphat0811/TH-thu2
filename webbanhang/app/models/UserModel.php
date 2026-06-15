<?php
class UserModel {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password) {
        // 🌟 BIẾN NẰM Ở ĐÂY: Tiến hành băm mật khẩu thô thành chuỗi bảo mật dạng BCRYPT
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Câu lệnh SQL chèn chuỗi mật khẩu đã mã hóa vào bảng users
        $query = "INSERT INTO " . $this->table . " (name, email, password, status) VALUES (:name, :email, :password, 'active')";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ':name' => $name, 
            ':email' => $email, 
            ':password' => $hashed_password // Truyền chuỗi hash vào đây
        ]);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateToken($id, $field, $token) {
        $query = "UPDATE " . $this->table . " SET $field = :token WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':token' => $token, ':id' => $id]);
    }

    public function updateProfile($id, $name, $avatar) {
        $query = "UPDATE " . $this->table . " SET name = :name, avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':name' => $name, ':avatar' => $avatar, ':id' => $id]);
    }

    public function changePassword($id, $new_password) {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':password' => $hashed, ':id' => $id]);
    }

    // --- Admin ---
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }
}