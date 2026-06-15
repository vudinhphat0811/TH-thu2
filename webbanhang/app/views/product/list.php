<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom">
        <div>
            <h2 class="font-weight-bold text-dark mb-1">📦 Hệ thống Kho Hàng</h2>
            <p class="text-muted small mb-0">Quản lý, theo dõi thông tin và cập nhật trạng thái các sản phẩm trong hệ thống</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="/Category/add" class="btn btn-info px-4 py-2 font-weight-bold d-inline-flex align-items-center btn-modern shadow-sm mr-2">
                <i class="fas fa-folder-plus mr-2"></i> Thêm danh mục
            </a>
            <a href="/Product/add" class="btn btn-success px-4 py-2 font-weight-bold d-inline-flex align-items-center btn-modern shadow-sm">
                <i class="fas fa-plus mr-2"></i> Thêm sản phẩm mới
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm p-3 bg-white text-dark h-100" style="border-radius: 10px; border-left: 4px solid #28a745 !important;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3 text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small font-weight-bold text-uppercase">Tổng sản phẩm</span>
                        <h4 class="font-weight-bold mb-0 text-dark"><?php echo count($products); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white text-dark h-100" style="border-radius: 10px; border-left: 4px solid #17a2b8 !important;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light p-3 mr-3 text-info d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-th-large fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small font-weight-bold text-uppercase">Phân loại hàng</span>
                        <h6 class="font-weight-bold mb-0 mt-1"><a href="/Category/add" class="text-info text-decoration-none">Cài đặt danh mục <i class="fas fa-arrow-right small ml-1"></i></a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0 bg-white">
            <?php if (!empty($products)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-align-middle mb-0">
                        <thead class="bg-light text-secondary font-weight-bold small text-uppercase">
                            <tr>
                                <th class="border-0 px-4" style="width: 80px;">Ảnh</th>
                                <th class="border-0">Thông tin sản phẩm</th>
                                <th class="border-0 text-center" style="width: 150px;">Danh mục</th>
                                <th class="border-0 text-right" style="width: 180px;">Giá bán</th>
                                <th class="border-0 text-center" style="width: 260px;">Thao tác quản trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="bg-light rounded overflow-hidden d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                            <?php if (!empty($product->image)): ?>
                                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                                     class="img-fluid object-fit-cover w-100 h-100">
                                            <?php else: ?>
                                                <img src="/images/no-image.png" 
                                                     alt="No-image" class="img-fluid opacity-40" style="max-height: 35px;">
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        <h6 class="font-weight-bold text-dark mb-1">
                                            <a href="/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark hover-blue">
                                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </h6>
                                        <p class="text-muted small text-truncate mb-0" style="max-width: 350px;">
                                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                                        </p>
                                    </td>

                                    <td class="text-center py-3">
                                        <span class="badge badge-pill badge-soft-info px-3 py-2 font-weight-bold">
                                            <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Máy tính bảng'; ?>
                                        </span>
                                    </td>

                                    <td class="text-right py-3 font-weight-bold text-dark pr-4">
                                        <?php echo number_format((float)$product->price, 0, ',', '.'); ?>đ
                                    </td>

                                    <td class="text-center py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-light text-muted border action-btn mr-1" title="Xem chi tiết">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                            <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-sm btn-light text-muted border action-btn mr-1" title="Chỉnh sửa">
                                                <i class="fas fa-pen text-warning"></i>
                                            </a>
                                            <a href="/Product/delete/<?php echo $product->id; ?>" 
                                               class="btn btn-sm btn-light text-muted border action-btn" 
                                               title="Xóa sản phẩm"
                                               onclick="return confirm('Hệ thống sẽ xóa vĩnh viễn sản phẩm [<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>]. Bạn có chắc chắn không?');">
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
                    <div class="mb-3"><i class="fas fa-box-open fa-4x opacity-30"></i></div>
                    <h5 class="font-weight-bold">Danh sách kho hàng trống</h5>
                    <p class="small text-muted">Vui lòng bấm nút phía trên để nhập thêm sản phẩm đầu tiên.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .bg-white { background-color: #ffffff !important; }
    .object-fit-cover { object-fit: cover; }
    .table-align-middle td, .table-align-middle th { vertical-align: middle !important; }
    .badge-soft-info { background-color: rgba(23, 162, 184, 0.1) !important; color: #17a2b8 !important; border: 1px solid rgba(23, 162, 184, 0.15); }
    .action-btn { width: 32px; height: 32px; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px !important; background-color: #ffffff !important; transition: all 0.15s ease-in-out; }
    .action-btn:hover { background-color: #f8f9fa !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transform: translateY(-1px); }
    .hover-blue:hover { color: #007bff !important; }
    .btn-modern { border-radius: 6px !important; }
</style>

<?php include 'app/views/shares/footer.php'; ?>