<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Danh sách sản phẩm</h1>
            <a href="/project1/Product/add" class="btn btn-success">+ Thêm sản phẩm mới</a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="fw-bold"><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-muted"><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-danger fw-bold"><?php echo number_format($product->getPrice(), 2); ?> VNĐ</td>
                            <td class="text-center">
                                <a href="/project1/Product/edit/<?php echo $product->getID(); ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="/project1/Product/delete/<?php echo $product->getID(); ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>