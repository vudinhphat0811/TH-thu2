<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
                <h4 class="font-weight-bold mb-4 text-dark"><i class="fas fa-user-id mr-2 text-primary"></i>Hồ Sơ Cá Nhân</h4>
                
                <?php if(isset($success)): ?>
                    <div class="alert alert-success small py-2 fw-bold"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form action="/Auth/profile" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <?php 
                            $userAvatar = (!empty($user->avatar) && file_exists($user->avatar)) ? $user->avatar : 'uploads/avatars/default.png';
                        ?>
                        <img src="/<?php echo $userAvatar; ?>" class="rounded-circle border shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                        <div class="mt-3">
                            <label class="form-label text-primary small font-weight-bold" style="cursor: pointer;">
                                <i class="fas fa-camera mr-1"></i> Thay đổi ảnh đại diện
                                <input type="file" name="avatar" class="d-none" accept="image/*">
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small font-weight-bold">ĐỊA CHỈ EMAIL</label>
                        <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small font-weight-bold">HỌ VÀ TÊN</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success font-weight-bold px-4 shadow-sm">LƯU THAY ĐỔI</button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
                <h4 class="font-weight-bold mb-4 text-dark"><i class="fas fa-key mr-2 text-warning"></i>Đổi Mật Khẩu</h4>
                <div id="pwd-msg" class="alert d-none small py-2 fw-bold"></div>
                
                <form id="change-pwd-form">
                    <div class="mb-3">
                        <label class="form-label text-muted small font-weight-bold">MẬT KHẨU HIỆN TẠI</label>
                        <input type="password" id="current_password" class="form-control" required placeholder="Nhập mật khẩu cũ...">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small font-weight-bold">MẬT KHẨU MỚI</label>
                        <input type="password" id="new_password" class="form-control" required placeholder="Nhập mật khẩu mới...">
                    </div>
                    <button type="submit" class="btn btn-warning font-weight-bold px-4 shadow-sm text-dark">CẬP NHẬT MẬT KHẨU</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('change-pwd-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const msgBox = document.getElementById('pwd-msg');
    const formData = new FormData();
    formData.append('current_password', document.getElementById('current_password').value);
    formData.append('new_password', document.getElementById('new_password').value);

    fetch('/Auth/changePassword', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        msgBox.className = "alert small py-2 fw-bold " + (data.status === 'success' ? 'alert-success' : 'alert-danger');
        msgBox.textContent = data.msg;
        msgBox.classList.remove('d-none');
        if(data.status === 'success') document.getElementById('change-pwd-form').reset();
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>