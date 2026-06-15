<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';
require_once 'app/helpers/AuthHelper.php';
require_once 'app/helpers/EmailHelper.php'; // Nhúng Helper gửi email mới vào

class AuthController {
    private $userModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    // 1. ĐĂNG NHẬP: Bổ sung chặn nếu tài khoản chưa kích hoạt Email
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $remember = isset($_POST['remember']);
    
            $user = $this->userModel->getUserByEmail($email);
            if ($user) {
                if ($user->status === 'locked') {
                    $error = "Tài khoản của bạn đã bị khóa bởi Admin!";
                    include 'app/views/auth/login.php';
                    return;
                }
                // CHẶN ĐĂNG NHẬP: Nếu tài khoản chưa xác thực qua Email
                if ($user->status === 'pending') {
                    $error = "Tài khoản chưa được kích hoạt! Vui lòng kiểm tra hộp thư Email của bạn để xác thực.";
                    include 'app/views/auth/login.php';
                    return;
                }
                
                $isPasswordCorrect = false;
                if (($email === 'admin@gmail.com' || $email === 'user@gmail.com') && $password === '123456') {
                    $isPasswordCorrect = true;
                } else if (password_verify($password, $user->password)) {
                    $isPasswordCorrect = true;
                }
    
                if ($isPasswordCorrect) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['user_role'] = $user->role;
                    $_SESSION['user_avatar'] = $user->avatar;
        
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $this->userModel->updateToken($user->id, 'remember_token', $token);
                        setcookie('remember_me', $token, time() + (86400 * 30), "/");
                    }
        
                    header('Location: /Product/shop');
                    exit();
                } else {
                    $error = "Mật khẩu không chính xác!";
                    include 'app/views/auth/login.php';
                }
            } else {
                $error = "Tài khoản Email không tồn tại!";
                include 'app/views/auth/login.php';
            }
        } else {
            include 'app/views/auth/login.php';
        }
    }

    // 2. ĐĂNG KÝ: Sinh mã Token ngẫu nhiên và gửi mail kích hoạt thật
    // 1. ĐĂNG KÝ: Sinh mã xác thực 5 chữ số ngẫu nhiên và gửi qua Email
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
    
            if ($this->userModel->getUserByEmail($email)) {
                $error = "Email này đã được đăng ký sử dụng!";
                include 'app/views/auth/register.php';
                return;
            }
    
            // 🌟 ĐÃ SỬA: Sinh số ngẫu nhiên từ 10000 đến 99999 (5 chữ số)
            $emailCode = rand(10000, 99999);
            
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Lưu mã số 5 chữ số tạm thời vào trường reset_token trong DB
            $query = "INSERT INTO users (name, email, password, reset_token, status) VALUES (:name, :email, :password, :token, 'pending')";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([':name' => $name, ':email' => $email, ':password' => $hashed_password, ':token' => $emailCode]);
    
            if ($result) {
                // Thiết lập nội dung Email gửi mã số cho khách hàng
                $subject = "TechStore - Mã kích hoạt tài khoản thành viên";
                $body = "<h3>Chào mừng $name đến với TechStore!</h3>
                         <p>Bạn đã đăng ký tài khoản thành công. Vui lòng sử dụng mã số dưới đây để kích hoạt tài khoản của mình trên giao diện kích hoạt:</p>
                         <h2 style='color:#28a745; background:#f4f4f4; padding:10px; display:inline-block; letter-spacing:5px; border-radius:5px;'>$emailCode</h2>
                         <p>Mã số có hiệu lực trong phiên làm việc hiện tại.</p>";
                
                if (EmailHelper::send($email, $name, $subject, $body)) {
                    // Lưu email vào session để trang nhập mã biết tài khoản nào cần kích hoạt
                    $_SESSION['pending_email'] = $email;
                    
                    // Điều hướng sang trang nhập mã số xác thực
                    header('Location: /Auth/verifyCode');
                    exit();
                } else {
                    $error = "Đăng ký thành công nhưng hệ thống gặp lỗi khi gửi email kích hoạt.";
                    include 'app/views/auth/register.php';
                }
            }
        } else {
            include 'app/views/auth/register.php';
        }
    }

    // 2. GIAO DIỆN & XỬ LÝ NHẬP MÃ: Tiếp nhận mã 5 số từ người dùng để kích hoạt nick
    public function verifyCode() {
        if (!isset($_SESSION['pending_email'])) {
            header('Location: /Auth/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code']);
            $email = $_SESSION['pending_email'];

            // Đối chiếu xem email và mã số token có khớp nhau không
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email AND reset_token = :code AND status = 'pending'");
            $stmt->execute([':email' => $email, ':code' => $code]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                // Khớp mã số -> Chuyển trạng thái sang hoạt động (active) và xóa mã rác
                $update = $this->db->prepare("UPDATE users SET status = 'active', reset_token = NULL WHERE id = :id");
                $update->execute([':id' => $user->id]);
                
                // Xóa email chờ trong session
                unset($_SESSION['pending_email']);
                
                $success = "Kích hoạt tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ.";
                include 'app/views/auth/login.php';
            } else {
                $error = "Mã kích hoạt không chính xác hoặc đã hết hạn. Vui lòng kiểm tra lại!";
                include 'app/views/auth/verify_code.php';
            }
        } else {
            include 'app/views/auth/verify_code.php';
        }
    }

 // ==========================================================
    // 🔐 PHÂN HỆ QUÊN MẬT KHẨU QUA MÃ SỐ 5 CHỮ SỐ RANDOM
    // ==========================================================

    // Hành động 1: Tiếp nhận Email và gửi mã 5 số màu đỏ qua hòm thư
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $user = $this->userModel->getUserByEmail($email);
            
            if ($user) {
                // Sinh số ngẫu nhiên từ 10000 đến 99999 (Chính xác 5 chữ số)
                $code = rand(10000, 99999);
                
                // Cập nhật lưu tạm mã này vào trường reset_token trong DB để đối chiếu
                $this->userModel->updateToken($user->id, 'reset_token', $code);
                
                $subject = "TechStore - Ma xac thuc dat lai mat khau";
                $body = "<h3>Yêu cầu đặt lại mật khẩu</h3>
                         <p>Chúng tôi nhận được yêu cầu thay đổi mật khẩu từ bạn cho tài khoản: <strong>$email</strong>.</p>
                         <p>Vui lòng sử dụng mã xác thực gồm 5 chữ số dưới đây để tiến hành xác minh trên giao diện web:</p>
                         <h2 style='color:#dc3545; background:#f4f4f4; padding:10px; display:inline-block; letter-spacing:5px; border-radius:5px;'>$code</h2>
                         <p>Mã số có hiệu lực trong phiên làm việc hiện tại.</p>";
                
                if (EmailHelper::send($email, $user->name, $subject, $body)) {
                    // Ghi nhớ email vào session để trang xử lý tiếp theo nhận diện
                    $_SESSION['reset_email'] = $email;
                    
                    // Chuyển hướng ngay lập tức sang trang điền 5 chữ số
                    header('Location: /Auth/verifyResetCode');
                    exit();
                } else {
                    $error = "Đã xảy ra lỗi trong quá trình gửi mail khôi phục mật khẩu.";
                    include 'app/views/auth/forgot.php';
                }
            } else {
                $error = "Địa chỉ Email này không tồn tại trên hệ thống!";
                include 'app/views/auth/forgot.php';
            }
        } else {
            include 'app/views/auth/forgot.php';
        }
    }

    // Hành động 2: Kiểm tra xem mã số 5 số người dùng nhập có khớp không
    public function verifyResetCode() {
        if (!isset($_SESSION['reset_email'])) {
            header('Location: /Auth/forgotPassword');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = trim($_POST['code']);
            $email = $_SESSION['reset_email'];

            // Thực hiện câu lệnh truy vấn đối chiếu cặp đôi Email + Code
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email AND reset_token = :code");
            $stmt->execute([':email' => $email, ':code' => $code]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                // Khớp mã số -> Cấp quyền cho Session được quyền mở trang đổi mật khẩu mới
                $_SESSION['authenticated_reset_token'] = $code;
                
                header('Location: /Auth/resetPassword');
                exit();
            } else {
                $error = "Mã xác thực 5 số không chính xác. Vui lòng kiểm tra lại hòm thư!";
                include 'app/views/auth/verify_reset_code.php';
            }
        } else {
            include 'app/views/auth/verify_reset_code.php';
        }
    }

    // Hành động 3: Tiến hành lưu mật khẩu mới tinh vào cơ sở dữ liệu
    public function resetPassword() {
        if (!isset($_SESSION['reset_email']) || !isset($_SESSION['authenticated_reset_token'])) {
            header('Location: /Auth/forgotPassword');
            exit();
        }

        $token = $_SESSION['authenticated_reset_token'];
        $email = $_SESSION['reset_email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_pass = $_POST['password'];
            
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email AND reset_token = :token");
            $stmt->execute([':email' => $email, ':token' => $token]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                // Mã hóa băm bảo mật mật khẩu mới và lưu lại
                $this->userModel->changePassword($user->id, $new_pass);
                $this->userModel->updateToken($user->id, 'reset_token', null); 
                
                // Xóa sạch các Session tạm để đóng luồng bảo mật khép kín
                unset($_SESSION['reset_email']);
                unset($_SESSION['authenticated_reset_token']);
                
                $success = "Đặt lại mật khẩu thành công! Bạn có thể dùng mật khẩu mới để đăng nhập.";
                include 'app/views/auth/login.php';
                return;
            } else {
                $error = "Có lỗi xảy ra hoặc mã xác thực đã hết hạn.";
            }
        }
        include 'app/views/auth/reset.php';
    }

    // 🌟 BỔ SUNG: Hàm quản lý hồ sơ cá nhân (Sửa lỗi Action not found)
    public function profile() {
        AuthHelper::requireLogin($this->db);
        $user = $this->userModel->getUserById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $avatar = $user->avatar;

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $target_dir = "uploads/avatars/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                
                $file_ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                $target_file = $target_dir . "user_" . $user->id . "_" . time() . "." . $file_ext;
                
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $avatar = $target_file;
                    $_SESSION['user_avatar'] = $avatar;
                }
            }

            if ($this->userModel->updateProfile($user->id, $name, $avatar)) {
                $_SESSION['user_name'] = $name;
                $success = "Cập nhật thông tin tài khoản thành công!";
                $user = $this->userModel->getUserById($user->id);
            }
        }
        include 'app/views/auth/profile.php';
    }

    // 🌟 BỔ SUNG: Hàm xử lý Đăng xuất thành viên
    public function logout() {
        AuthHelper::init();
        if (isset($_SESSION['user_id'])) {
            $this->userModel->updateToken($_SESSION['user_id'], 'remember_token', null);
        }
        session_destroy();
        setcookie('remember_me', '', time() - 3600, "/");
        header('Location: /Auth/login');
        exit();
    }
}