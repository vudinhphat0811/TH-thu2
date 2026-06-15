<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Hệ Thống Cổng Kết Nối RESTful API</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .api-card { border-radius: 12px; transition: transform 0.2s; }
        .api-card:hover { transform: translateY(-3px); }
        .badge-method { width: 80px; font-size: 0.9rem; padding: 6px; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="font-weight-bold text-dark"><i class="fas fa-network-wired text-primary mr-2"></i>TechStore RESTful API Dashboard</h1>
        <p class="text-muted">Tài liệu hướng dẫn kết nối và phân quyền hệ thống dữ liệu dành cho Client (Mobile App / Postman)</p>
        <span class="badge badge-success p-2">Trạng thái: Đang hoạt động tốt (Localhost)</span>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-dark text-white font-weight-bold py-3">
                    <i class="fas fa-code mr-2"></i>Danh Sách Các Đường Dẫn (Endpoints)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light text-secondary small text-uppercase font-weight-bold">
                                <tr>
                                    <th class="border-0 pl-4">Phương thức</th>
                                    <th class="border-0">Đường dẫn (URL)</th>
                                    <th class="border-0">Phân quyền</th>
                                    <th class="border-0">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pl-4 border-top-0"><span class="badge badge-primary badge-method text-uppercase">POST</span></td>
                                    <td class="font-weight-bold text-danger border-top-0">/api/login</td>
                                    <td class="border-top-0"><span class="badge badge-secondary">Public</span></td>
                                    <td class="text-muted border-top-0">Đăng nhập tài khoản để lấy mã JWT Token mã hóa.</td>
                                </tr>
                                <tr>
                                    <td class="pl-4"><span class="badge badge-success badge-method text-uppercase">GET</span></td>
                                    <td class="font-weight-bold text-primary">/api</td>
                                    <td><span class="badge badge-secondary">Public</span></td>
                                    <td class="text-muted">Lấy toàn bộ danh sách sản phẩm (Dạng JSON).</td>
                                </tr>
                                <tr>
                                    <td class="pl-4"><span class="badge badge-success badge-method text-uppercase">GET</span></td>
                                    <td class="font-weight-bold text-primary">/api/{id}</td>
                                    <td><span class="badge badge-secondary">Public</span></td>
                                    <td class="text-muted">Xem chi tiết một sản phẩm theo ID.</td>
                                </tr>
                                <tr>
                                    <td class="pl-4"><span class="badge badge-warning badge-method text-white text-uppercase">POST</span></td>
                                    <td class="font-weight-bold text-primary">/api</td>
                                    <td><span class="badge badge-danger">Admin Only</span></td>
                                    <td class="text-muted">Thêm sản phẩm mới. (Yêu cầu đính kèm Bearer Token).</td>
                                </tr>
                                <tr>
                                    <td class="pl-4"><span class="badge badge-info badge-method text-uppercase">PUT</span></td>
                                    <td class="font-weight-bold text-primary">/api/{id}</td>
                                    <td><span class="badge badge-danger">Admin Only</span></td>
                                    <td class="text-muted">Cập nhật sản phẩm. (Yêu cầu đính kèm Bearer Token).</td>
                                </tr>
                                <tr>
                                    <td class="pl-4"><span class="badge badge-danger badge-method text-uppercase">DELETE</span></td>
                                    <td class="font-weight-bold text-primary">/api/{id}</td>
                                    <td><span class="badge badge-danger">Admin Only</span></td>
                                    <td class="text-muted">Xóa sản phẩm khỏi kho. (Yêu cầu đính kèm Bearer Token).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 api-card bg-white p-4 mb-4">
                <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-shield-alt text-danger mr-2"></i>Cấu hình Bảo mật</h5>
                <p class="small text-muted">Đối với các phương thức yêu cầu quyền <span class="text-danger font-weight-bold">Admin Only</span>, bạn phải truyền mã Token nhận được sau khi login vào phần Header của request theo định dạng sau:</p>
                <div class="bg-dark text-warning p-3 rounded small font-weight-bold mb-2">
                    Key: Authorization<br>
                    Value: Bearer eyJhbGciOi...
                </div>
                <small class="text-muted font-italic">* Lưu ý: Token có thời gian hết hạn trong vòng 1 tiếng kể từ khi khởi tạo.</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>