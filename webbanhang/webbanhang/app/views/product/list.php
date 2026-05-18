<?php include 'app/views/shares/header.php'; ?>

<div class="card border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
    <div class="card-body p-4 d-flex justify-content-between align-items-center text-white">
        <div>
            <h1 class="h3 fw-bold mb-1" style="letter-spacing: -0.5px;">Hệ Thống Quản Lý Sản Phẩm</h1>
            <p class="mb-0 opacity-75 table-responsive-sm" style="font-size: 0.9rem;">Xem, tìm kiếm và điều chỉnh danh mục hàng hóa thương mại</p>
        </div>
        <a href="/webbanhang/Product/add" class="btn btn-light text-primary fw-bold px-4 py-2.5 shadow-sm rounded-pill d-flex align-items-center" style="gap: 8px; transition: all 0.3s ease;">
            <i class="fas fa-plus-circle text-primary"></i> Khởi tạo sản phẩm
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-secondary d-flex align-items-center" style="gap: 8px;">
            <i class="fas fa-boxes text-muted"></i> Tất cả mặt hàng 
            <span class="badge bg-light text-dark rounded-pill border ms-2" style="font-size: 0.8rem;"><?php echo count($products); ?> mục</span>
        </h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
            <thead class="table-light text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-4" style="width: 80px;">Hình ảnh</th>
                    <th>Thông tin sản phẩm</th>
                    <th style="width: 180px;">Danh mục</th>
                    <th class="text-end" style="width: 160px;">Giá bán</th>
                    <th class="text-center" style="width: 180px;">Thao tác hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-50"></i>
                            Chưa có sản phẩm nào được tạo trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                    <tr style="transition: background-color 0.2s ease;">
                        <td class="ps-4">
                            <?php if ($product->image): ?>
                                <img src="<?php echo $product->image; ?>" 
                                     class="rounded-3 border object-fit-cover shadow-sm" 
                                     style="width: 50px; height: 50px; object-fit: cover;" 
                                     alt="Product">
                            <?php else: ?>
                                <div class="rounded-3 bg-light border text-muted d-flex flex-column align-items-center justify-content-center shadow-sm" 
                                     style="width: 50px; height: 50px; font-size: 0.65rem;">
                                    <i class="fas fa-image mb-0.5 opacity-50"></i> Thô
                                </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="fw-bold text-dark mb-0.5">
                                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark link-primary">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </div>
                            <small class="text-muted text-truncate d-block" style="max-width: 350px;">
                                <?php 
                                    $desc = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                                    echo mb_strlen($desc) > 60 ? mb_substr($desc, 0, 60) . '...' : ($desc ? $desc : 'Chưa có mô tả ngắn...');
                                ?>
                            </small>
                        </td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded-pill" style="font-size: 0.8rem; font-weight: 500;">
                                <i class="fas fa-folder me-1" style="font-size: 0.75rem;"></i>
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>

                        <td class="text-end fw-bold text-success pe-4">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> <span class="small fw-normal text-muted">VND</span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group shadow-sm rounded-2 overflow-hidden" role="group">
                                <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" 
                                   class="btn btn-sm btn-white border-end px-3" 
                                   title="Xem chi tiết" style="background: #fff;">
                                    <i class="fas fa-eye text-secondary"></i>
                                </a>
                                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                                   class="btn btn-sm btn-white border-end px-3" 
                                   title="Chỉnh sửa" style="background: #fff;">
                                    <i class="fas fa-pencil-alt text-warning"></i>
                                </a>
                                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                   class="btn btn-sm btn-white px-3" 
                                   title="Xóa sản phẩm" style="background: #fff;"
                                   onclick="return confirm('Hành động này không thể hoàn tác! Bạn thực sự muốn xóa sản phẩm này?');">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>