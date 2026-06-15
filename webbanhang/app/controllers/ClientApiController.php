<?php
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/UserModel.php';
require_once 'app/helpers/JwtHelper.php';

class ClientApiController {
    private $db;
    private $productModel;
    private $userModel;

    public function __construct() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    /**
     * 📝 1. API ĐĂNG KÝ CHO KHÁCH HÀNG (Tự động Active thẳng - Không kẹt luồng Mail)
     * Đường dẫn Postman: POST http://localhost:8080/api/client/register
     */
    public function register() {
        $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
        $name     = trim($data['name'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ Name, Email và Password!"]);
            return;
        }

        // Mã hóa mật khẩu theo cấu trúc chuẩn Bcrypt của PHP
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Ép trạng thái 'active' và phân hệ 'user' cho luồng API độc lập
        $query = "INSERT INTO users (name, email, password, status, role) 
                  VALUES (:name, :email, :password, 'active', 'user')";
        $stmt = $this->db->prepare($query);
        
        $result = $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $hashed_password
        ]);

        if ($result) {
            http_response_code(201);
            echo json_encode([
                "status" => "success",
                "message" => "Đăng ký tài khoản khách hàng qua API thành công! Tài khoản đã tự kích hoạt sang Active.",
                "note" => "Hãy lấy Email và Password này chuyển sang cổng login để lấy Token ngay."
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Không thể tạo tài khoản. Email này có thể đã được sử dụng."]);
        }
    }

    /**
     * 🔐 2. API ĐĂNG NHẬP KHÁCH HÀNG (Gõ tài khoản/mật khẩu lấy Token trực tiếp)
     * Đường dẫn Postman: POST http://localhost:8080/api/client/login
     */
    public function login() {
        $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
        $email    = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ Email và Password!"]);
            return;
        }

        // Lấy thông tin user dựa vào email thông qua UserModel
        $user = $this->userModel->getUserByEmail($email);
        
        // Xác thực tài khoản và so khớp mật khẩu đã băm trong DB
        if ($user && password_verify($password, $user->password)) {
            
            // Đóng gói mảng Payload token cho phân hệ khách hàng
            $payload = [
                "user_id"   => $user->id,
                "user_name" => $user->name,
                "user_role" => $user->role 
            ];

            // Tạo chuỗi Token mã hóa JWT
            $token = JwtHelper::generateToken($payload);

            http_response_code(200);
            echo json_encode([
                "status"  => "success",
                "message" => "Khách hàng đăng nhập thành công!",
                "token"   => $token,
                "user"    => [
                    "id"   => $user->id,
                    "name" => $user->name,
                    "role" => $user->role
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Tài khoản hoặc mật khẩu không chính xác."]);
        }
    }

    /**
     * 💳 3. CLIENT API: ĐẶT HÀNG TỰ ĐỘNG GOM TOÀN BỘ SẢN PHẨM TRONG GIỎ HÀNG DB
     * Đường dẫn Postman: POST http://localhost:8080/api/client/checkout
     */
    public function checkout() {
        // 1. Kiểm tra Token để nhận diện chính xác Khách hàng đang đăng nhập
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $userId = $userData['user_id'];
        $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;

        // 2. Tiếp nhận thông tin giao nhận hàng
        $shippingName    = trim($data['name'] ?? '');
        $shippingPhone   = trim($data['phone'] ?? '');
        $shippingAddress = trim($data['address'] ?? '');

        if (empty($shippingName) || empty($shippingPhone) || empty($shippingAddress)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ Tên, SĐT và Địa chỉ nhận hàng!"]);
            return;
        }

        // 3. TỰ ĐỘNG LẤY TẤT CẢ SẢN PHẨM TRONG GIỎ HÀNG CỦA USER RA
        $queryCart = "SELECT c.product_id, c.quantity, p.price, p.name 
                      FROM cart c 
                      JOIN product p ON c.product_id = p.id 
                      WHERE c.user_id = :user_id";
        $stmtCart = $this->db->prepare($queryCart);
        $stmtCart->execute([':user_id' => $userId]);
        $cartItems = $stmtCart->fetchAll(PDO::FETCH_ASSOC);

        // Nếu giỏ hàng trống rỗng thì không cho đặt hàng
        if (empty($cartItems)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Giỏ hàng của bạn đang trống! Hãy thêm sản phẩm trước khi thanh toán."]);
            return;
        }

        // 4. Tính toán tổng tiền hóa đơn từ dữ liệu Database đã quét được
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        try {
            // Khởi động Transaction để bảo vệ toàn vẹn dữ liệu
            $this->db->beginTransaction();
            $queryOrder = "INSERT INTO orders (user_id, total_price, status, name, phone, address, created_at) 
                           VALUES (:user_id, :total_price, 'Đang xử lý', :name, :phone, :address, NOW())";
            $stmtOrder = $this->db->prepare($queryOrder);
            $stmtOrder->execute([
                ':user_id'     => $userId,
                ':total_price' => $totalPrice,
                ':name'        => $shippingName,
                ':phone'       => $shippingPhone,
                ':address'     => $shippingAddress
            ]);
            
            // Lấy ID của đơn hàng vừa tạo xong
            $orderId = $this->db->lastInsertId();

            // 6. Vòng lặp lưu chi tiết từng món hàng vào bảng order_details
            $queryDetail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                            VALUES (:order_id, :product_id, :quantity, :price)";
            $stmtDetail = $this->db->prepare($queryDetail);

            foreach ($cartItems as $item) {
                $stmtDetail->execute([
                    ':order_id'   => $orderId,
                    ':product_id' => $item['product_id'],
                    ':quantity'   => $item['quantity'],
                    ':price'      => $item['price']
                ]);
            }

            // 7. DỌN SẠCH GIỎ HÀNG: Đơn đã lên thì giỏ hàng phải trống
            $queryClearCart = "DELETE FROM cart WHERE user_id = :user_id";
            $stmtClearCart = $this->db->prepare($queryClearCart);
            $stmtClearCart->execute([':user_id' => $userId]);

            // Xác nhận hoàn thành chuỗi lệnh ghi dữ liệu an toàn
            $this->db->commit();

            // 8. Trả về kết quả thành công mỹ mãn cho Client
            http_response_code(201);
            echo json_encode([
                "status" => "success",
                "message" => "Đặt hàng thành công! Hệ thống đã tự động chốt toàn bộ sản phẩm trong giỏ hàng.",
                "hoa_don" => [
                    "order_id" => $orderId,
                    "nguoi_nhan" => $shippingName,
                    "phone" => $shippingPhone,
                    "address" => $shippingAddress,
                    "tong_tien" => $totalPrice,
                    "trang_thai" => "Đang xử lý",
                    "so_luong_mat_hang" => count($cartItems),
                    "clear_cart" => true
                ]
            ]);

        } catch (Exception $e) {
            // Nếu có bất kỳ lỗi gì xảy ra, hủy bỏ toàn bộ thao tác để tránh rác Database
            $this->db->rollBack();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Lỗi hệ thống khi đặt hàng: " . $e->getMessage()]);
        }
    }

    /**
     * 📥 4. API THÊM SẢN PHẨM VÀO GIỎ HÀNG: POST http://localhost:8080/api/client/addtocart
     */
    public function addToCart() {
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $userId = $userData['user_id'];
        $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
        
        $productId = $data['product_id'] ?? null;
        $quantity  = intval($data['quantity'] ?? 1);

        if (!$productId || $quantity <= 0) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Dữ liệu sản phẩm không hợp lệ!"]);
            return;
        }

        // Kiểm tra xem sản phẩm này đã có trong giỏ hàng của user này chưa
        $queryCheck = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->execute([':user_id' => $userId, ':product_id' => $productId]);
        $cartItem = $stmtCheck->fetch(PDO::FETCH_OBJ);

        if ($cartItem) {
            // Nếu đã có -> Cộng dồn số lượng mới vào
            $newQuantity = $cartItem->quantity + $quantity;
            $queryUpdate = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $stmtUpdate = $this->db->prepare($queryUpdate);
            $stmtUpdate->execute([':quantity' => $newQuantity, ':id' => $cartItem->id]);
        } else {
            // Nếu chưa có -> Tạo dòng mới vào bảng cart
            $queryInsert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
            $stmtInsert = $this->db->prepare($queryInsert);
            $stmtInsert->execute([':user_id' => $userId, ':product_id' => $productId, ':quantity' => $quantity]);
        }

        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Đã thêm sản phẩm vào giỏ hàng thành công!"]);
    }

    /**
     * 🗂️ 5. API XEM GIỎ HÀNG & TỰ ĐỘNG TÍNH TỔNG TIỀN: GET http://localhost:8080/api/client/viewcart
     */
    public function viewCart() {
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $userId = $userData['user_id'];

        // Lấy toàn bộ sản phẩm trong giỏ kèm thông tin giá, tên từ bảng product
        $query = "SELECT c.id as cart_id, c.product_id, c.quantity, p.name, p.price 
                  FROM cart c
                  JOIN product p ON c.product_id = p.id
                  WHERE c.user_id = :user_id ORDER BY c.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Vòng lặp tính toán tổng tiền hóa đơn bảo mật
        $totalCartPrice = 0;
        foreach ($cartItems as $item) {
            $item->subtotal = $item->price * $item->quantity; // Thành tiền từng món
            $totalCartPrice += $item->subtotal; // Cộng dồn tổng tiền giỏ hàng
        }

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "tong_tien_giỏ_hang" => $totalCartPrice,
            "data" => $cartItems
        ]);
    }

    /**
     * 🗑️ 6. API XÓA SẢN PHẨM KHỎI GIỎ: POST http://localhost:8080/api/client/removefromcart
     */
    public function removeFromCart() {
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $userId = $userData['user_id'];
        $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;
        $productId = $data['product_id'] ?? null;

        if (!$productId) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Thiếu ID sản phẩm cần xóa!"]);
            return;
        }

        // Xóa sản phẩm cụ thể khỏi giỏ hàng của đúng User đang đăng nhập
        $query = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([':user_id' => $userId, ':product_id' => $productId]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Đã xóa sản phẩm khỏi giỏ hàng!"]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Sản phẩm không tồn tại trong giỏ hàng của bạn."]);
        }
    }

    /**
     * 📜 7. API LỊCH SỬ ĐƠN HÀNG: GET http://localhost:8080/api/client/orders
     */
    public function orders() {
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $userId = $userData['user_id']; 

        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($orders as $order) {
            $queryDetail = "SELECT od.*, p.name as product_name 
                            FROM order_details od
                            JOIN product p ON od.product_id = p.id
                            WHERE od.order_id = :order_id";
            $stmtDetail = $this->db->prepare($queryDetail);
            $stmtDetail->execute([':order_id' => $order->id]);
            $order->details = $stmtDetail->fetchAll(PDO::FETCH_OBJ);
        }

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Lấy lịch sử đơn hàng của bạn thành công!",
            "data" => $orders
        ]);
    }

    /**
     * 👤 8. API XEM THÔNG TIN CÁ NHÂN: GET http://localhost:8080/api/client/profile
     */
    public function profile() {
        $userData = $this->checkUserAuthorization();
        if (!$userData) return;

        $user = $this->userModel->getUserById($userData['user_id']);

        if ($user) {
            unset($user->password);
            unset($user->remember_token);
            unset($user->reset_token);

            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $user
            ]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin thành viên."]);
        }
    }

    /**
     * HÀM NỘI BỘ: XÁC THỰC BEARER TOKEN CỦA KHÁCH HÀNG
     */
    private function checkUserAuthorization() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Vui lòng đăng nhập tài khoản khách hàng để thực hiện tính năng này."]);
            return false;
        }

        $token = $matches[1];
        $userData = JwtHelper::validateToken($token);

        if (!$userData) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại."]);
            return false;
        }

        return $userData;
    }
}