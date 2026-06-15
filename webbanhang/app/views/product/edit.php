<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-warning text-dark text-center py-3" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h3 class="fw-bold mb-0"><i class="fas fa-edit me-2"></i>Chỉnh sửa sản phẩm</h3>
                </div>
                
                <div class="card-body p-4 p-lg-5">
                    
                    <form action="/Product/update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                        
                        <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary">Tên sản phẩm:</label>
                            <input type="text" class="form-control form-control-lg shadow-sm" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold text-secondary">Mô tả sản phẩm:</label>
                            <textarea class="form-control shadow-sm" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold text-secondary">Giá bán (VND):</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-muted">💰</span>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo $product->price; ?>" min="0" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label for="category_id" class="form-label fw-bold text-secondary">Danh mục:</label>
                                <select class="form-select shadow-sm" id="category_id" name="category_id" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 border rounded p-3 bg-light">
                            <label class="form-label fw-bold text-primary mb-3"><i class="fas fa-image me-2"></i>Quản lý hình ảnh:</label>
                            
                            <div class="row align-items-center text-center text-md-start">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <p class="small text-muted mb-2">Ảnh hiện tại:</p>
                                    <?php if (!empty($product->image)): ?>
                                        <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-thumbnail shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="/images/no-image.png" class="img-thumbnail opacity-50" style="height: 120px;">
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-8">
                                    <p class="small text-muted mb-2">Tải lên ảnh mới (nếu muốn thay đổi):</p>
                                    <input type="file" class="form-control shadow-sm" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                    
                                    <div id="new-preview-container" class="mt-3 d-none">
                                        <p class="small text-success mb-1 fw-bold">Xem trước ảnh mới:</p>
                                        <img id="image-preview" src="#" alt="Xem trước" class="img-thumbnail border-success" style="height: 80px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-3">
                            <a href="/Product/list" class="btn btn-outline-secondary flex-fill py-2.5 fw-bold">
                                <i class="fas fa-times me-1"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning flex-fill py-2.5 fw-bold shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> Cập nhật ngay
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
        const container = document.getElementById('new-preview-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('d-none');
        }
    }
</script>

<style>
    .form-control:focus, .form-select:focus { border-color: #ffc107; box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25); }
</style>