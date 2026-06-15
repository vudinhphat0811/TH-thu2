<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header bg-success text-white text-center py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h3 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới</h3>
                </div>
                
                <div class="card-body p-4">
                    
                    <form action="/Product/save" method="POST" enctype="multipart/form-data" class="needs-validation">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-secondary">Tên sản phẩm:</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Nhập tên sản phẩm..." required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-secondary">Mô tả sản phẩm:</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Viết mô tả ngắn về sản phẩm..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label fw-bold text-secondary">Giá bán (VND):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-muted">💰</span>
                                <input type="number" class="form-control form-control-lg" id="price" name="price" min="0" step="any" placeholder="Ví dụ: 150000" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-bold text-secondary">Danh mục:</label>
                            <select class="form-select form-select-lg" id="category_id" name="category_id" required>
                                <option value="" disabled selected>-- Chọn danh mục sản phẩm --</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->id; ?>">
                                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-4 pb-3 border-bottom">
                            <label for="image" class="form-label fw-bold text-secondary">Hình ảnh sản phẩm:</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            
                            <div class="text-center mt-3">
                                <img id="image-preview" src="#" alt="Xem trước ảnh" class="img-thumbnail d-none shadow-sm" style="max-height: 180px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="/Product/list" class="btn btn-outline-secondary flex-fill py-2.5 fw-bold">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-success flex-fill py-2.5 fw-bold shadow-sm">
                                <i class="fas fa-save me-1"></i> Lưu sản phẩm
                            </button>
                        </div>

                    </form>
                    
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.classList.add('d-none');
        }
    }
</script>