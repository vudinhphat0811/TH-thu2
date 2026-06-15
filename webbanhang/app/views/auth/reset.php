<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h3 class="text-center font-weight-bold text-dark mb-2">Mật Khẩu Mới</h3>
        <p class="text-center text-muted small mb-4">Mã số hợp lệ! Vui lòng thiết lập mật khẩu mới an toàn cho tài khoản của bạn.</p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 font-weight-bold"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="/Auth/resetPassword" method="POST">
            <div class="form-group mb-4">
                <label class="form-label text-muted small font-weight-bold">NHẬP MẬT KHẨU MỚI</label>
                <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự..." required style="border-radius: 6px;">
            </div>
            
            <button type="submit" class="btn btn-success w-100 font-weight-bold py-2 shadow-sm" style="border-radius: 6px;">
                <i class="fas fa-check-circle mr-1"></i> HOÀN TẤT ĐỔI MẬT KHẨU
            </button>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>