<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h3 class="text-center font-weight-bold text-dark mb-2">Xác Minh Mã Số</h3>
        <p class="text-center text-muted small mb-4">Hệ thống đã gửi mã đặt lại mật khẩu gồm 5 số đến Email: <br><strong class="text-primary"><?php echo $_SESSION['reset_email']; ?></strong></p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 font-weight-bold text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/Auth/verifyResetCode" method="POST">
            <div class="form-group mb-4">
                <label class="form-label text-muted small font-weight-bold text-center d-block">NHẬP MÃ ĐẶT LẠI MẬT KHẨU (5 SỐ)</label>
                <input type="text" name="code" class="form-control text-center font-weight-bold text-danger" 
                       placeholder="• • • • •" maxlength="5" pattern="\d{5}" inputmode="numeric" style="font-size: 2rem; letter-spacing: 10px;" required autocomplete="off">
            </div>
            
            <button type="submit" class="btn btn-danger w-100 font-weight-bold py-2 shadow-sm" style="border-radius: 6px;">XÁC MINH NGAY</button>
            
            <div class="text-center mt-3 small">
                <a href="/Auth/forgotPassword" class="text-decoration-none text-muted"><i class="fas fa-redo mr-1"></i>Gửi lại mã khác</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>