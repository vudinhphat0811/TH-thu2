<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold text-dark mb-0">
            <i class="fas fa-th-large text-info mr-2"></i>Quản Lý Danh Mục
        </h3>
        <!-- Nút thêm danh mục mới -->
        <a href="/Category/add" class="btn btn-success font-weight-bold shadow-sm" style="border-radius: 6px;">
            <i class="fas fa-plus-circle mr-1"></i> Thêm danh mục mới
        </a>
    </div>

    <!-- Khung bảng danh sách -->
    <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 12px;">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary font-weight-bold small text-uppercase">
                <tr>
                    <th class="border-0 px-4 py-3" style="width: 15%;">ID</th>
                    <th class="border-0 py-3" style="width: 55%;">Tên danh mục sản phẩm</th>
                    <th class="border-0 text-center py-3" style="width: 30%;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Kiểm tra nếu mảng danh mục không rỗng -->
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td class="px-4 py-3 font-weight-bold text-muted">
                            #<?php echo $category->id; ?>
                        </td>
                        <td class="align-middle font-weight-bold text-dark">
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td class="text-center align-middle">
                            <!-- Nút sửa danh mục -->
                            <a href="/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-outline-primary font-weight-bold mr-2 px-3" style="border-radius: 6px;">
                                <i class="fas fa-edit mr-1"></i> Sửa
                            </a>
                            <!-- Nút xóa danh mục -->
                            <a href="/Category/delete/<?php echo $category->id; ?>" class="btn btn-sm btn-outline-danger font-weight-bold px-3" style="border-radius: 6px;"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Tất cả sản phẩm thuộc danh mục này cũng có thể bị ảnh hưởng!')">
                                <i class="fas fa-trash-alt mr-1"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?> <!-- Viết chuẩn không dùng dấu ; ở đây -->
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open mr-1"></i> Chưa có danh mục nào được tạo.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>