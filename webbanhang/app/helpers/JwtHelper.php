<?php
class JwtHelper {
    private static $secret_key = "TechStore_Localhost_Secret_Key_2026";

    // Sinh mã JWT Token khi Admin đăng nhập thành công
    public static function generateToken($payload) {
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = self::base64UrlEncode(json_encode($headers));
        
        $payload['exp'] = time() + 3600; // Hết hạn sau 1 tiếng
        $payload_encoded = self::base64UrlEncode(json_encode($payload));
        
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", self::$secret_key, true);
        $signature_encoded = self::base64UrlEncode($signature);
        
        return "$headers_encoded.$payload_encoded.$signature_encoded";
    }

    // Giải mã và xác thực mã Token gửi lên
    public static function validateToken($token) {
        $token_parts = explode('.', $token);
        if (count($token_parts) !== 3) return false;

        $headers_encoded = $token_parts[0];
        $payload_encoded = $token_parts[1];
        $signature_encoded = $token_parts[2];

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", self::$secret_key, true);
        $valid_signature_encoded = self::base64UrlEncode($signature);

        if ($signature_encoded !== $valid_signature_encoded) return false;

        $payload = json_decode(base64_decode(strtr($payload_encoded, '-_', '+/')), true);
        
        if (isset($payload['exp']) && $payload['exp'] < time()) return false;

        return $payload; 
    }

    private static function base64UrlEncode($data) {
        return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
    }
}