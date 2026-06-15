<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5" style="max-width: 450px;">
    <div class="card shadow border-0 p-4" style="border-radius: 12px;">
        <h4 class="text-center font-weight-bold text-dark mb-3">Quên Mật Khẩu</h4>
        <p class="text-muted small text-center mb-4">Nhập email đăng ký tài khoản, hệ thống sẽ kiểm tra và cấp link đặt lại mật khẩu tức thì.</p>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small py-2 fw-bold"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert alert-success small py-2 fw-bold"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="/Auth/forgotPassword" method="POST">
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">ĐỊA CHỈ EMAIL</label>
                <input type="email" name="email" class="form-control" required placeholder="name@example.com">
            </div>
            <button type="submit" class="btn btn-dark w-100 font-weight-bold py-2 shadow-sm">TÌM TÀI KHOẢN</button>
            <div class="text-center mt-3 small">
                <a href="/Auth/login" class="text-decoration-none text-muted">Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</div>