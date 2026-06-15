<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Thiết Bị Công Nghệ Chính Hãng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Định dạng bo tròn hoàn hảo cho ảnh đại diện (Avatar) trên thanh Navbar */
        .nav-avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            border: 1.5px solid #fff;
        }
        /* Hiệu ứng đổi màu mượt mà khi hover qua các link điều hướng */
        .hover-effect:hover {
            color: #28a745 !important;
            transition: all 0.2s ease-in-out;
        }
        /* Định vị số lượng sản phẩm nhỏ gọn nằm trên Icon giỏ hàng */
        .badge-cart {
            top: -5px;
            right: -5px;
            font-size: 0.7rem;
            padding: 3px 6px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-2.5">
    <div class="container">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="/Product/shop">
            <i class="fas fa-laptop-code mr-2 text-success fa-lg"></i>TechStore
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-white hover-effect" href="/Product/shop">
                        <i class="fas fa-store mr-1 text-muted"></i> Cửa hàng
                    </a>
                </li>
                
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item dropdown ml-lg-2">
                        <a class="nav-link dropdown-toggle font-weight-bold text-info" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-shield mr-1"></i> Quản trị hệ thống
                        </a>
                        <div class="dropdown-menu shadow border-0 mt-2" aria-labelledby="adminDropdown" style="border-radius: 8px;">
                            <a class="dropdown-item py-2" href="/Product">
                                <i class="fas fa-boxes mr-2 text-secondary"></i> Kho sản phẩm
                            </a>
                            <a class="dropdown-item py-2" href="/Product/add">
                                <i class="fas fa-plus-circle mr-2 text-success"></i> Nhập sản phẩm mới
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2" href="/Category/list">
                                <i class="fas fa-th-large mr-2 text-info"></i> Danh mục sản phẩm
                            </a>
                            <a class="dropdown-item py-2" href="/Admin/users">
                                <i class="fas fa-users-cog mr-2 text-warning"></i> Quản lý thành viên
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav align-items-center">
                <li class="nav-item mr-lg-4 mb-3 mb-lg-0">
                    <a class="nav-link position-relative p-2" href="/Product/cart">
                        <i class="fas fa-shopping-cart fa-lg text-light hover-effect"></i>
                        <?php if(!empty($_SESSION['cart'])): ?>
                            <span class="badge badge-danger badge-pill position-absolute badge-cart shadow-sm">
                                <?php echo count($_SESSION['cart']); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                $avatarPath = (!empty($_SESSION['user_avatar']) && file_exists($_SESSION['user_avatar'])) ? $_SESSION['user_avatar'] : 'uploads/avatars/default.png';
                            ?>
                            <img src="/<?php echo $avatarPath; ?>" class="nav-avatar mr-2 shadow-sm" alt="User Avatar">
                            <span class="font-weight-bold mr-1"><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2" aria-labelledby="userDropdown" style="border-radius: 8px; min-width: 180px;">
                            <a class="dropdown-item py-2" href="/Auth/profile">
                                <i class="fas fa-id-card mr-2 text-primary fa-fw"></i> Hồ sơ cá nhân
                            </a>
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <a class="dropdown-item py-2" href="/Admin/users">
                                    <i class="fas fa-shield-alt mr-2 text-warning fa-fw"></i> Trang quản trị
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 text-danger font-weight-bold" href="/Auth/logout">
                                <i class="fas fa-sign-out-alt mr-2 fa-fw"></i> Đăng xuất
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white-50 hover-effect d-flex align-items-center" href="#" id="guestDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg mr-2 text-light"></i> Tài khoản
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-3" aria-labelledby="guestDropdown" style="border-radius: 8px; min-width: 220px;">
                            <p class="small text-muted mb-2 text-center">Xin chào khách quý!</p>
                            <a class="btn btn-sm btn-success btn-block font-weight-bold mb-2 py-2" href="/Auth/login" style="border-radius: 6px;">
                                <i class="fas fa-sign-in-alt mr-1"></i> Đăng nhập
                            </a>
                            <a class="btn btn-sm btn-outline-secondary btn-block font-weight-bold py-2" href="/Auth/register" style="border-radius: 6px;">
                                <i class="fas fa-user-plus mr-1"></i> Đăng ký thành viên
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">