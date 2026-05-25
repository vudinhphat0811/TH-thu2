<?php include 'app/views/shares/header.php'; ?>

<div class="bg-dark text-white py-5 mb-5 position-relative overflow-hidden" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2426') center/cover;">
    <div class="container py-4 text-center">
        <h1 class="display-4 fw-bold mb-2 text-uppercase tracking-wide">🚀 TechZone Store</h1>
        <p class="lead mb-0 text-white-50">Thế giới công nghệ chính hãng - Giá tốt nhất thị trường</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">
                        <i class="fas fa-th-large me-2 text-primary"></i>Danh Mục Sản Phẩm
                    </h5>
                    <div class="list-group list-group-flush gap-1">
                        <a href="/webbanhang/Product/shop" class="list-group-item list-group-item-action border-0 rounded <?php echo empty($_GET['category_id']) ? 'active' : ''; ?> px-3 py-2.5">
                            <i class="fas fa-border-all me-2"></i>Tất cả sản phẩm
                        </a>
                        
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <?php 
                                    $isActive = (isset($_GET['category_id']) && $_GET['category_id'] == $cat->id) ? 'active' : ''; 
                                    $textClass = (isset($_GET['category_id']) && $_GET['category_id'] == $cat->id) ? '' : 'text-muted'; 
                                ?>
                                <a href="/webbanhang/Product/shop?category_id=<?php echo $cat->id; ?>" 
                                   class="list-group-item list-group-item-action border-0 rounded px-3 py-2.5 <?php echo $isActive . ' ' . $textClass; ?> hover-sidebar">
                                    <i class="fas fa-chevron-right small me-2 opacity-50"></i>
                                    <?php echo htmlspecialchars($cat->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 10px;">
                <div class="card-body p-3 bg-white" style="border-radius: 10px;">
                    <form method="GET" action="/webbanhang/Product/shop" class="row g-2 align-items-center">
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                </div>
                                <input type="text" name="search" class="form-control border-left-0 shadow-none" 
                                       placeholder="Nhập tên sản phẩm hoặc từ khóa cần tìm..." 
                                       value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                       style="border-top-right-radius: 6px; border-bottom-right-radius: 6px; height: calc(1.5em + .75rem + 2px);">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mt-md-0">
                            <button type="submit" class="btn btn-success btn-block font-weight-bold" style="border-radius: 6px; height: calc(1.5em + .75rem + 2px);">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 shadow-sm" style="border-radius: 8px;">
                <span class="text-muted fw-semibold mb-0">
                    Hiển thị <?php echo count($products); ?> sản phẩm
                </span>
                
                <?php if(!empty($_GET['category_id']) || !empty($_GET['search'])): ?>
                    <a href="/webbanhang/Product/shop" class="btn btn-sm btn-outline-secondary font-weight-bold bg-white px-3" style="border-radius: 6px;">
                        <i class="fas fa-times-circle mr-1"></i> Xóa bộ lọc
                    </a>
                <?php endif; ?>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm product-card transition-all bg-white">
                                
                                <div class="bg-white d-flex align-items-center justify-content-center overflow-hidden position-relative" style="height: 220px; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2.5 py-1.5 fw-bold shadow-sm">Trả góp 0%</span>
                                    
                                    <?php if (!empty($product->image)): ?>
                                        <img src="http://localhost:8080/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-fluid w-100 h-100 object-fit-cover product-img">
                                    <?php else: ?>
                                        <img src="http://localhost:8080/webbanhang/images/no-image.png" 
                                             alt="Không có ảnh" class="img-fluid opacity-40" style="max-height: 120px;">
                                    <?php endif; ?>
                                </div>

                                <div class="card-body d-flex flex-column p-4 bg-white">
                                    <p class="text-uppercase tracking-wider small text-muted fw-bold mb-1">
                                        <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Máy tính bảng'; ?>
                                    </p>
                                    
                                    <h5 class="card-title fw-bold mb-2">
                                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark hover-success text-truncate-2" style="min-height: 48px;">
                                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted text-truncate-2 small mb-4 flex-grow-1">
                                        <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>

                                    <div class="mb-3 border-top pt-3">
                                        <span class="text-danger fw-extrabold h5 mb-0">
                                            <?php echo number_format((float)$product->price, 0, ',', '.'); ?>đ
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary flex-fill py-2 d-flex align-items-center justify-content-center gap-1 hover-scale font-weight-bold btn-custom-sm" title="Thêm vào giỏ">
                                            <i class="fas fa-cart-plus"></i> <span class="d-none d-sm-inline">Thêm giỏ</span>
                                        </a>
                                        <a href="/webbanhang/Product/buyNow/<?php echo $product->id; ?>" class="btn btn-danger flex-fill py-2 d-flex align-items-center justify-content-center gap-1 hover-scale font-weight-bold btn-custom-sm" title="Mua trực tiếp luôn">
                                            <i class="fas fa-bolt"></i> <span>Mua ngay</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5 text-muted">
                        <div class="mb-3"><i class="fas fa-search-minus fa-4x opacity-30"></i></div>
                        <h5 class="font-weight-bold">Không tìm thấy sản phẩm nào khớp!</h5>
                        <p class="small text-muted">Hệ thống không tìm thấy sản phẩm thuộc bộ lọc này. Vui lòng chọn danh mục khác.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<style>
    .bg-white { background-color: #ffffff !important; }
    .transition-all { transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .product-card { border-radius: 12px; }
    .product-card:hover { transform: translateY(-6px); box-shadow: 0 1rem 2rem rgba(0,0,0,.08)!important; }
    .product-img { transition: transform 0.5s ease; }
    .product-card:hover .product-img { transform: scale(1.06); }
    .object-fit-cover { object-fit: cover; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .hover-success:hover { color: #198754 !important; }
    .hover-sidebar:hover:not(.active) { background-color: #f8f9fa; color: #198754 !important; padding-left: 1.25rem !important; transition: all 0.2s ease; }
    .fw-extrabold { font-weight: 800; }
    .hover-scale:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15) !important; transition: all 0.2s ease; }
    .btn-custom-sm { font-size: 0.85rem !important; border-radius: 6px !important; }
</style>

<?php include 'app/views/shares/footer.php'; ?>