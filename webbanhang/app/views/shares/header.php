<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="/webbanhang/Product/">
            <i class="fas fa-laptop-code mr-2"></i>TechStore
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-white font-weight-bold" href="/webbanhang/Product/shop">
                        <i class="fas fa-shopping-bag mr-1 text-success"></i> Cửa hàng
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/">
                        <i class="fas fa-boxes mr-1"></i> Danh sách sản phẩm (Admin)
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/add">
                        <i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-info font-weight-bold" href="/webbanhang/Category/list">
                        <i class="fas fa-th-large mr-1"></i> Danh mục sản phẩm
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="/webbanhang/Product/cart">
                        <i class="fas fa-shopping-cart fa-lg text-light"></i>
                        <?php if(!empty($_SESSION['cart'])): ?>
                            <span class="badge badge-danger badge-pill position-absolute" style="top: 0; right: 0;">
                                <?php echo count($_SESSION['cart']); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">