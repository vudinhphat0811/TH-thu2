<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <h1 class="fw-bold text-dark mb-4"><i class="fas fa-shopping-cart text-success mr-2"></i>Giỏ hàng của bạn</h1>

    <?php if (!empty($cart)): ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 p-3" style="border-radius: 12px;">
                    <div class="table-responsive">
                        <table class="table table-align-middle border-0 mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="border-0">Sản phẩm</th>
                                    <th scope="col" class="border-0 text-center">Giá</th>
                                    <th scope="col" class="border-0 text-center" style="width: 160px;">Số lượng</th>
                                    <th scope="col" class="border-0 text-right">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalCartPrice = 0;
                                foreach ($cart as $id => $item): 
                                    $itemTotal = (float)$item['price'] * (int)$item['quantity'];
                                    $totalCartPrice += $itemTotal;
                                ?>
                                    <tr>
                                        <td class="align-middle border-top-0 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded overflow-hidden mr-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; min-width: 70px;">
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid object-fit-cover w-100 h-100">
                                                    <?php else: ?>
                                                        <img src="/images/no-image.png" class="img-fluid opacity-40" style="max-height: 40px;">
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-bold text-dark mb-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="align-middle text-center text-muted border-top-0">
                                            <?php echo number_format((float)$item['price'], 0, ',', '.'); ?>đ
                                        </td>
                                        
                                        <td class="align-middle text-center border-top-0">
                                            <div class="input-group justify-content-center">
                                                <div class="input-group-prepend">
                                                    <a href="/Product/decreaseCart/<?php echo $id; ?>" class="btn btn-outline-secondary btn-sm px-2 d-flex align-items-center" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                                        <i class="fas fa-minus fa-xs"></i>
                                                    </a>
                                                </div>
                                                <span class="form-control form-control-sm text-center font-weight-bold bg-white" style="max-width: 50px; pointer-events: none; height: auto; py: 1px;">
                                                    <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                                <div class="input-group-append">
                                                    <a href="/Product/increaseCart/<?php echo $id; ?>" class="btn btn-outline-secondary btn-sm px-2 d-flex align-items-center" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">
                                                        <i class="fas fa-plus fa-xs"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="align-middle text-right font-weight-bold text-danger border-top-0">
                                            <?php echo number_format($itemTotal, 0, ',', '.'); ?>đ
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="/Product/shop" class="btn btn-outline-secondary px-4 py-2 font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 bg-light" style="border-radius: 12px; border-left: 4px solid #28a745 !important;">
                    <h5 class="font-weight-bold text-dark mb-4 border-bottom pb-2">Tóm tắt đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Tạm tính:</span>
                        <span><?php echo number_format($totalCartPrice, 0, ',', '.'); ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 pb-2 text-muted">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success font-weight-bold">Miễn phí</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4 pt-2 border-top">
                        <span class="font-weight-bold text-dark h5 mb-0">Tổng cộng:</span>
                        <span class="text-danger font-weight-bold h4 mb-0"><?php echo number_format($totalCartPrice, 0, ',', '.'); ?>đ</span>
                    </div>
                    
                    <a href="/Product/checkout" class="btn btn-success btn-block btn-lg py-3 shadow-sm font-weight-bold" style="border-radius: 8px; font-size: 1.1rem;">
                        Tiến hành thanh toán <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="card shadow-sm border-0 py-5 text-center my-4" style="border-radius: 12px;">
            <div class="card-body py-5">
                <div class="text-muted mb-4 opacity-30">
                    <i class="fas fa-shopping-basket fa-4x text-secondary"></i>
                </div>
                <h4 class="font-weight-bold text-secondary mb-2">Giỏ hàng của bạn đang trống</h4>
                <p class="text-muted mb-4">Hãy chọn mua thêm các sản phẩm công nghệ tuyệt vời từ cửa hàng nhé.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="/Product/shop" class="btn btn-success px-4 py-2.5 font-weight-bold shadow-sm mr-2" style="border-radius: 8px;">
                        <i class="fas fa-shopping-bag mr-1"></i> Đến Cửa Hàng Mua Sắm
                    </a>
                    <button class="btn btn-light px-4 py-2.5 font-weight-bold border text-muted" style="border-radius: 8px;" disabled>
                        <i class="fas fa-credit-card mr-1"></i> Thanh Toán
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .table-align-middle td, .table-align-middle th { vertical-align: middle !important; }
</style>

<?php include 'app/views/shares/footer.php'; ?>