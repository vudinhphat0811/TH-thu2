<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h4 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-folder-plus text-success mr-2"></i>Thêm Danh Mục Mới
                    </h4>
                </div>
                
                <div class="card-body p-4 bg-white" style="border-radius: 12px;">
                    <form method="POST" action="/webbanhang/Category/save">
                        
                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-secondary small text-uppercase">Tên danh mục:</label>
                            <input type="text" id="name" name="name" 
                                   class="form-control form-control-lg <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                                   placeholder="Ví dụ: Điện thoại, Laptop, Phụ kiện..." style="border-radius: 8px; font-size: 0.95rem;">
                            
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback font-weight-bold"><?php echo $errors['name']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="font-weight-bold text-secondary small text-uppercase">Mô tả danh mục:</label>
                            <textarea id="description" name="description" class="form-control" rows="4" 
                                      placeholder="Nhập mô tả ngắn gọn về nhóm danh mục này..." style="border-radius: 8px; font-size: 0.95rem;"></textarea>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <a href="/webbanhang/Product/" class="text-decoration-none text-muted small font-weight-bold">
                                <i class="fas fa-arrow-left mr-1"></i> Quay lại kho hàng
                            </a>
                            <button type="submit" class="btn btn-success px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 8px; font-size: 0.95rem;">
                                LƯU DANH MỤC
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-white { background-color: #ffffff !important; }
    .form-control:focus {
        box-shadow: none;
        border-color: #28a745;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>