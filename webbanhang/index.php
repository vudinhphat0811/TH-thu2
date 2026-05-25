<?php
// Bắt đầu session ở đầu file index.php theo đúng sách hướng dẫn
session_start();

require_once 'app/models/ProductModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Loại bỏ thư mục dự án 'webbanhang' nếu nó xuất hiện trong mảng định tuyến
if (isset($url[0]) && strtolower($url[0]) === 'webbanhang') {
    array_shift($url); 
}

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) . 'Controller' : 'ProductController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Kiểm tra xem controller có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Thử tìm với dạng viết thường hoàn toàn xem sao
    $controllerName = isset($url[0]) && $url[0] != '' ? strtolower($url[0]) . 'Controller' : 'ProductController';
    
    if (!file_exists('app/controllers/' . $controllerName . '.php')) {
        die('Controller not found');
    }
}

// Nhúng file Controller vào hệ thống
require_once 'app/controllers/' . $controllerName . '.php';

// Khởi tạo Object của Controller
$controller = new $controllerName();

// Kiểm tra phương thức (Action) có tồn tại trong Controller không
if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
?>