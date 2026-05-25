<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom">
        <div>
            <h2 class="font-weight-bold text-dark mb-1">📁 Quản lý Danh Mục</h2>
            <p class="text-muted small mb-0">Quản lý, phân loại các nhóm sản phẩm kinh doanh trên hệ thống cửa hàng</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="/webbanhang/Product" class="btn btn-light border px-4 py-2 font-weight-bold d-inline-flex align-items-center btn-modern shadow-sm mr-2" style="border-radius: 6px;">
                <i class="fas fa-box mr-2 text-success"></i> Kho sản phẩm
            </a>
            <a href="/webbanhang/Category/add" class="btn btn-info px-4 py-2 font-weight-bold d-inline-flex align-items-center btn-modern shadow-sm" style="border-radius: 6px;">
                <i class="fas fa-plus mr-2"></i> Thêm danh mục mới
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white text-dark mb-3 mb-md-0" style="border-radius: 10px; border-left: 4px solid #17a2b8 !important;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3 text-info d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-th-large fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small font-weight-bold text-uppercase">Tổng số danh mục</span>
                        <h4 class="font-weight-bold mb-0 text-dark"><?php echo count($categories); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0 bg-white">
            <?php if (!empty($categories)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-align-middle mb-0">
                        <thead class="bg-light text-secondary font-weight-bold small text-uppercase">
                            <tr>
                                <th class="border-0 px-4" style="width: 100px;">Mã số</th>
                                <th class="border-0" style="width: 250px;">Tên danh mục</th>
                                <th class="border-0">Mô tả chi tiết</th>
                                <th class="border-0 text-center" style="width: 200px;">Thao tác quản trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="px-4 py-3 font-weight-bold text-muted">
                                        #<?php echo $category->id; ?>
                                    </td>

                                    <td class="py-3">
                                        <span class="badge badge-pill badge-soft-info px-3 py-2 font-weight-bold" style="font-size: 0.9rem;">
                                            <i class="fas fa-folder mr-1"></i> 
                                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>

                                    <td class="py-3 text-muted small">
                                        <?php echo !empty($category->description) ? htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8') : '<em class="opacity-50">Chưa có mô tả cụ thể cho danh mục này</em>'; ?>
                                    </td>

                                    <td class="text-center py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-light text-muted border action-btn mr-1" title="Chỉnh sửa">
                                                <i class="fas fa-pen text-warning"></i>
                                            </a>
                                            <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" 
                                               class="btn btn-sm btn-light text-muted border action-btn" 
                                               title="Xóa danh mục"
                                               onclick="return confirm('Hệ thống sẽ xóa danh mục [<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>]. Bạn có chắc chắn không?');">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center my-5 py-5 text-muted">
                    <div class="mb-3"><i class="fas fa-folder-open fa-4x opacity-30"></i></div>
                    <h5 class="font-weight-bold">Chưa có danh mục nào</h5>
                    <p class="small text-muted">Vui lòng bấm nút phía trên để tạo nhóm danh mục phân loại đầu tiên.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .bg-white { background-color: #ffffff !important; }
    .table-align-middle td, .table-align-middle th { vertical-align: middle !important; }
    
    .badge-soft-info {
        background-color: rgba(23, 162, 184, 0.1) !important;
        color: #17a2b8 !important;
        border: 1px solid rgba(23, 162, 184, 0.15);
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px !important;
        background-color: #ffffff !important;
        transition: all 0.15s ease-in-out;
    }
    .action-btn:hover {
        background-color: #f8f9fa !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transform: translateY(-1px);
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>