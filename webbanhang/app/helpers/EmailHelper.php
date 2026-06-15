<?php
// Nhúng các file thư viện PHPMailer thủ công
require_once 'app/libs/PHPMailer/Exception.php';
require_once 'app/libs/PHPMailer/PHPMailer.php';
require_once 'app/libs/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper {
    public static function send($toEmail, $toName, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình Máy chủ SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                     // Server SMTP của Gmail
            $mail->SMTPAuth   = true;                                 // Bật xác thực SMTP
            $mail->Username   = 'vphat544@gmail.com';            // Email của bạn dùng để gửi
            $mail->Password   = 'ouiqtykzcovovbhx';                // Mật khẩu ứng dụng (App Password) của Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Mã hóa TLS
            $mail->Port       = 587;                                  // Cổng kết nối TLS
            $mail->CharSet    = 'UTF-8';                              // Đảm bảo hiển thị Tiếng Việt không lỗi font

            // Người nhận & Người gửi
            $mail->setFrom('vphat544@gmail.com', 'TechStore Support');
            $mail->addAddress($toEmail, $toName);

            // Nội dung Mail
            $mail->isHTML(true);                                      // Thiết lập định dạng Mail là HTML để chèn link bấm
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Bạn có thể ghi log lỗi ở đây nếu gửi thất bại: $mail->ErrorInfo
            return false;
        }
    }
}