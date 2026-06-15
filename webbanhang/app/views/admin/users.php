<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <h3 class="font-weight-bold mb-4 text-dark">🛠️ Quản Lý Người Dùng (Admin)</h3>
    
    <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 12px;">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary font-weight-bold small text-uppercase">
                <tr>
                    <th class="border-0 px-4 py-3">Họ tên thành viên</th>
                    <th class="border-0 py-3">Email tài khoản</th>
                    <th class="border-0 text-center py-3">Vai trò</th>
                    <th class="border-0 text-center py-3">Trạng thái</th>
                    <th class="border-0 text-center py-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td class="px-4 py-3">
                        <div class="d-flex align-items-center">
                            <?php 
                                $userAvatar = (!empty($u->avatar) && file_exists($u->avatar)) ? $u->avatar : 'uploads/avatars/default.png';
                            ?>
                            <img src="/<?php echo $userAvatar; ?>" class="rounded-circle mr-2 border shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="font-weight-bold text-dark"><?php echo htmlspecialchars($u->name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </td>

                    <td class="align-middle"><?php echo htmlspecialchars($u->email, ENT_QUOTES, 'UTF-8'); ?></td>

                    <td class="text-center align-middle">
                        <?php if ($u->id !== $_SESSION['user_id']): ?>
                            <a href="/Admin/changeRole/<?php echo $u->id; ?>" 
                               class="badge <?php echo $u->role === 'admin' ? 'badge-danger bg-danger' : 'badge-secondary bg-secondary'; ?> text-white p-2 text-decoration-none border-0 shadow-sm d-inline-block" 
                               style="min-width: 80px; font-size: 0.8rem; border-radius: 4px;"
                               title="Bấm vào để thay đổi vai trò"
                               onclick="return confirm('Bạn có chắc chắn muốn thay đổi vai trò của tài khoản này không?')">
                                <i class="fas <?php echo $u->role === 'admin' ? 'fa-user-shield' : 'fa-user'; ?> mr-1"></i>
                                <?php echo strtoupper($u->role); ?>
                            </a>
                        <?php else: ?>
                            <span class="badge badge-danger bg-danger text-white p-2 d-inline-block" style="min-width: 80px; font-size: 0.8rem; border-radius: 4px;">
                                <i class="fas fa-user-shield mr-1"></i> <?php echo strtoupper($u->role); ?>
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center align-middle">
                        <span class="badge <?php echo $u->status === 'active' ? 'badge-success bg-success' : 'badge-dark bg-dark'; ?> text-white p-2" style="border-radius: 4px;">
                            <?php echo $u->status === 'active' ? 'ĐANG CHẠY' : 'BỊ KHÓA'; ?>
                        </span>
                    </td>

                    <td class="text-center align-middle">
                        <?php if ($u->id !== $_SESSION['user_id']): ?>
                            <a href="/Admin/toggleStatus/<?php echo $u->id; ?>" class="btn btn-sm <?php echo $u->status === 'active' ? 'btn-outline-danger' : 'btn-success text-white'; ?> font-weight-bold px-3 shadow-sm" style="border-radius: 6px;">
                                <i class="fas <?php echo $u->status === 'active' ? 'fa-lock' : 'fa-lock-open'; ?> mr-1"></i>
                                <?php echo $u->status === 'active' ? 'Khóa lại' : 'Mở khóa'; ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted small font-italic">Đang hoạt động</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>