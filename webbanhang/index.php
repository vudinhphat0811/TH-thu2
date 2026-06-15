<?php
// 1. Khởi động Session hệ thống ngay đầu file theo đúng tiêu chuẩn
session_start();

// 2. Nhúng các file cấu hình cốt lõi và Helper bảo mật hệ thống
require_once 'app/config/database.php';
require_once 'app/helpers/AuthHelper.php';

// 3. Thiết lập kết nối Database phục vụ cho việc kiểm tra Token (Remember Me)
$dbForAuth = (new Database())->getConnection();

// 4. Kích hoạt tính năng tự động nhận diện người dùng qua Cookie (Nếu có tích Remember Me)
AuthHelper::checkLogin($dbForAuth);

// 5. Tiếp nhận tham số URL và tiến hành làm sạch dữ liệu đầu vào
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 6. Loại bỏ thư mục dự án 'webbanhang' nếu nó xuất hiện trong mảng định tuyến (Dành cho Laragon)
if (isset($url[0]) && strtolower($url[0]) === 'webbanhang') {
    array_shift($url); 
}

// =========================================================================
// 🌟 BỘ ĐỊNH TUYẾN THÔNG MINH: PHÂN CHIA LUỒNG ADMIN API & CLIENT API & WEB MVC
// =========================================================================
if (isset($url[0]) && strtolower($url[0]) === 'api') {
    
    // ĐƯỜNG DẪN DÀNH CHO KHÁCH HÀNG: localhost/api/client/...
    if (isset($url[1]) && strtolower($url[1]) === 'client') {
        $controllerName = 'ClientApiController';
        
        // Xác định hành động (Ví dụ: /api/client/checkout -> chạy hàm checkout())
        $action = isset($url[2]) && $url[2] != '' ? strtolower($url[2]) : 'index';
        
        // Các tham số truyền vào phía sau (Ví dụ: /api/client/orders/5)
        $params = array_slice($url, 3);
    } 
    // ĐƯỜNG DẪN DÀNH CHO ADMIN: localhost/api/...
    else {
        $controllerName = 'ApiController';
        
        if (isset($url[1]) && strtolower($url[1]) === 'login') {
            $action = 'login';
            $params = [];
        } 
        // 🌟 TỐI ƯU: Tự động nhận diện linh hoạt các hàm Quản trị (Đơn hàng, Danh mục, Cấp quyền)
        else if (isset($url[1]) && in_array(strtolower($url[1]), ['orders', 'updateorderstatus', 'categories', 'updateuserrole'])) {
            $action = $url[1]; // Gán trực tiếp tên Action trùng với tên hàm bạn viết trong Controller
            $params = array_slice($url, 2); // Bóc tách các tham số bổ sung phía sau nếu có
        } 
        // Mặc định nếu không khớp các hàm trên thì hiểu là đang CRUD sản phẩm
        else {
            $action = 'products';
            $params = isset($url[1]) && $url[1] != '' ? [$url[1]] : [];
        }
    }
} else {
    // =========================================================================
    // LUỒNG ĐỊNH TUYẾN WEB MVC HTML THÔNG THƯỜNG (Giữ nguyên gốc)
    // =========================================================================
    
    // 7. Xác định tên lớp Controller (Mặc định nếu URL trống là ProductController)
    $controllerName = isset($url[0]) && $url[0] != '' ? ucfirst(strtolower($url[0])) . 'Controller' : 'ProductController';

    // 8. Xác định tên phương thức Action xử lý (Mặc định nếu URL trống là index)
    $action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
    
    // Mảng tham số truyền vào hàm Web thông thường từ phần tử thứ 3 trở đi
    $params = array_slice($url, 2);
}

// =========================================================================
// TỰ ĐỘNG KIỂM TRA FILE VÀ KÍCH HOẠT CONTROLLER
// =========================================================================

// 9. Kiểm tra tính hợp lệ và sự tồn tại của file Controller trong mã nguồn
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Thử kiểm tra phương án viết thường hoàn toàn tên Controller (Dành cho Web thông thường)
    if (isset($url[0])) {
        $controllerName = strtolower($url[0]) . 'Controller';
    }
    
    if (!file_exists('app/controllers/' . $controllerName . '.php')) {
        header("HTTP/1.0 404 Not Found");
        die('Lỗi hệ thống: Phân hệ (Controller) không tồn tại.');
    }
}

// 10. Nhúng file Controller tương ứng đã được xác thực vào hệ thống
require_once 'app/controllers/' . $controllerName . '.php';

// 11. Khởi tạo thực thể (Object) từ Class của Controller đó
$controller = new $controllerName();

// 12. Kiểm tra phương thức xử lý hành động (Action) có nằm trong Controller hay không
if (!method_exists($controller, $action)) {
    header("HTTP/1.0 404 Not Found");
    die('Lỗi hệ thống: Hành động (Action) không tồn tại.');
}

// 13. Khởi chạy Action xử lý đồng thời truyền mảng tham số đã được bóc tách vào hàm
call_user_func_array([$controller, $action], $params);
?>