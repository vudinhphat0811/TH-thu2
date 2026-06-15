<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h3 class="text-center font-weight-bold text-dark mb-4">Đăng Nhập</h3>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 fw-bold"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/Auth/login" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">EMAIL</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn..." required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">MẬT KHẨU</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
            </div>
            
            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label text-muted small" for="remember">Ghi nhớ đăng nhập (Remember Me)</label>
            </div>
            
            <button type="submit" class="btn btn-success w-100 font-weight-bold py-2 shadow-sm">ĐĂNG NHẬP</button>
            
            <div class="text-center mt-3 small">
                <a href="/Auth/forgotPassword" class="text-decoration-none">Quên mật khẩu?</a> | 
                <a href="/Auth/register" class="text-decoration-none text-primary fw-bold">Đăng ký thành viên</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>