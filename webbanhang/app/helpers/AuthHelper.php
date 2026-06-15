<?php
class AuthHelper {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Kiểm tra và tự động đăng nhập bằng cookie Remember Me
    public static function checkLogin($db = null) {
        self::init();
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        if (isset($_COOKIE['remember_me']) && $db !== null) {
            $token = $_COOKIE['remember_me'];
            $stmt = $db->prepare("SELECT * FROM users WHERE remember_token = :token AND status = 'active'");
            $stmt->execute([':token' => $token]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_role'] = $user->role;
                $_SESSION['user_avatar'] = $user->avatar;
                return true;
            }
        }
        return false;
    }

    // Chặn nếu không phải Admin
    public static function requireAdmin($db = null) {
        if (!self::checkLogin($db) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /Auth/login');
            exit();
        }
    }

    // Chặn nếu chưa đăng nhập thành viên
    public static function requireLogin($db = null) {
        if (!self::checkLogin($db)) {
            header('Location: /Auth/login');
            exit();
        }
    }
}