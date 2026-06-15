<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h3 class="text-center font-weight-bold text-dark mb-2">Xác Thực Tài Khoản</h3>
        <p class="text-center text-muted small mb-4">Hệ thống đã gửi mã xác thực 5 số đến Email: <br><strong class="text-dark"><?php echo $_SESSION['pending_email']; ?></strong></p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 fw-bold text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/Auth/verifyCode" method="POST">
            <div class="form-group mb-4">
                <label class="form-label text-muted small fw-bold text-center d-block">NHẬP MÃ XÁC THỰC (5 CHỮ SỐ)</label>
                <input type="text" name="code" class="form-control text-center font-weight-bold text-success" 
                       placeholder="• • • • •" maxlength="5" pattern="\d{5}" style="font-size: 1.8rem; letter-spacing: 8px;" required autocomplete="off">
            </div>
            
            <button type="submit" class="btn btn-success w-100 font-weight-bold py-2 shadow-sm">KÍCH HOẠT NGAY</button>
            
            <div class="text-center mt-3 small">
                <a href="/Auth/login" class="text-decoration-none">Quay lại Đăng nhập</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>