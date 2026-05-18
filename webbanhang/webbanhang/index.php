<?php
// Bật session nếu hệ thống của bạn có dùng giỏ hàng (Cart)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/models/ProductModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Loại bỏ thư mục dự án 'webbanhang' nếu nó xuất hiện trong mảng định tuyến
if (isset($url[0]) && strtolower($url[0]) === 'webbanhang') {
    array_shift($url); 
}

// Lấy tên Controller và chuẩn hóa chữ cái đầu tiên viết hoa (Ví dụ: product -> ProductController)
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) . 'Controller' : 'ProductController';

// Lấy tên Action (mặc định là index)
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Kiểm tra xem file Controller có tồn tại không
$controllerFile = 'app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    // Nếu không tìm thấy, thử tìm với dạng viết thường hoàn toàn xem sao
    $controllerName = isset($url[0]) && $url[0] != '' ? strtolower($url[0]) . 'Controller' : 'ProductController';
    $controllerFile = 'app/controllers/' . $controllerName . '.php';
    
    if (!file_exists($controllerFile)) {
        die("Controller not found: Đang tìm kiếm file '" . $controllerFile . "' nhưng không thấy. Hãy kiểm tra lại tên file!");
    }
}

// Nhúng file Controller vào hệ thống
require_once $controllerFile;

// Khởi tạo Object của Controller
$controller = new $controllerName();

// Kiểm tra phương thức (Action) có tồn tại trong Controller không
if (!method_exists($controller, $action)) {
    die("Action not found: Không tìm thấy hàm '" . $action . "' trong class " . $controllerName);
}

// Chạy Action và truyền các tham số phía sau (nếu có)
// CHỈ CHẠY ĐÚNG 1 LẦN DUY NHẤT Ở ĐÂY
call_user_func_array([$controller, $action], array_slice($url, 2));
?>