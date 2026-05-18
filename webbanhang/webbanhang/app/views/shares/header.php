
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Trị Kho Hàng - Web bán hàng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
    :root {
        --admin-bg: #f4f6f9;
        --sidebar-dark: #1e293b;
        --accent-blue: #2a5298;
        --text-main: #334155;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--admin-bg);
        color: var(--text-main);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    /* Thanh Điều Hướng Cao Cấp */
    .navbar-admin {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 0.85rem 0;
    }

    .admin-brand {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff !important;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-brand span {
        background: linear-gradient(45deg, #00f2fe 0%, #4facfe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }

    /* Định hình liên kết trên Navbar */
    .navbar-admin .nav-link {
        color: #94a3b8 !important;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.5rem 1.25rem !important;
        border-radius: 8px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar-admin .nav-item.active .nav-link,
    .navbar-admin .nav-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.08);
    }

    /* Khu vực bao bọc nội dung chính */
    .page-wrapper {
        min-height: 75vh;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    /* Thiết kế Form chuyên nghiệp */
    .form-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.65rem 1rem;
        height: auto;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 4px rgba(79, 172, 254, 0.12);
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .btn {
        border-radius: 8px !important;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-admin sticky-top">
        <div class="container">
            <a class="navbar-brand admin-brand" href="/webbanhang/Product/">
                <i class="fas fa-cubes text-info"></i> CMS <span>STORE</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-toggle="collapse" data-target="#navbarNavAdmin"
                aria-controls="navbarNavAdmin" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAdmin">
                <ul class="navbar-nav ml-auto" style="gap: 6px;">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/">
                            <i class="fas fa-table-list"></i> Danh sách kho
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/add">
                            <i class="fas fa-circle-plus"></i> Tạo sản phẩm
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container page-wrapper">