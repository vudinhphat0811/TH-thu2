<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-warning">
                    <div class="card-header bg-warning text-dark text-center">
                        <h3 class="mb-0">Sửa thông tin sản phẩm</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="/project1/Product/edit/<?php echo $product->getID(); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Mô tả:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Giá:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                                <a href="/project1/Product/list" class="btn btn-outline-secondary">Quay lại danh sách</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>