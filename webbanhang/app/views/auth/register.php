<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h3 class="text-center font-weight-bold text-dark mb-4">Đăng Ký Tài Khoản</h3>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 fw-bold"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert alert-success small py-2 fw-bold"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="/Auth/register" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">HỌ TÊN</label>
                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">EMAIL</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">MẬT KHẨU</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu an toàn..." required>
            </div>
            <button type="submit" class="btn btn-primary w-100 font-weight-bold py-2 shadow-sm">ĐĂNG KÝ NGAY</button>
            <div class="text-center mt-3 small">
                <a href="/Auth/login" class="text-decoration-none text-muted">Đã có tài khoản? Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</div>