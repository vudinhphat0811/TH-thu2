<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h4 class="fw-bold text-dark mb-0"><i class="fas fa-shipping-fast text-primary mr-2"></i>Thông tin giao hàng</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="/Product/processCheckout" id="checkout-form">
                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-secondary">Họ và tên người nhận:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-user text-muted"></i></span>
                                </div>
                                <input type="text" id="name" name="name" class="form-control border-left-0" placeholder="Ví dụ: Nguyễn Văn A" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="phone" class="font-weight-bold text-secondary">Số điện thoại:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-phone text-muted"></i></span>
                                </div>
                                <input type="text" id="phone" name="phone" class="form-control border-left-0" placeholder="Ví dụ: 0912345678" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="address" class="font-weight-bold text-secondary">Địa chỉ nhận hàng:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                </div>
                                <textarea id="address" name="address" class="form-control border-left-0" rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required></textarea>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-credit-card mr-2"></i>Phương thức thanh toán</h6>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="paymentMethod1" name="paymentMethod" class="custom-control-input" checked>
                                <label class="custom-control-label" for="paymentMethod1">Thanh toán khi nhận hàng (COD)</label>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <a href="/Product/cart" class="text-decoration-none text-muted font-weight-bold">
                                <i class="fas fa-chevron-left mr-1"></i> Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm font-weight-bold" style="border-radius: 8px;">
                                XÁC NHẬN ĐẶT HÀNG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius: 12px; background-color: #f8f9fa;">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">Đơn hàng của bạn</h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-4" style="max-height: 400px; overflow-y: auto;">
                        <?php 
                        $total = 0;
                        if (!empty($_SESSION['cart'])): 
                            foreach ($_SESSION['cart'] as $item): 
                                $subtotal = (float)$item['price'] * (int)$item['quantity'];
                                $total += $subtotal;
                        ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="position-relative">
                                    <div class="bg-white border rounded overflow-hidden d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid object-fit-cover w-100 h-100">
                                        <?php else: ?>
                                            <img src="/images/no-image.png" class="img-fluid opacity-40" style="max-height: 30px;">
                                        <?php endif; ?>
                                    </div>
                                    <span class="badge badge-secondary badge-pill position-absolute" style="top: -10px; right: -10px; border: 2px solid #f8f9fa;">
                                        <?php echo $item['quantity']; ?>
                                    </span>
                                </div>
                                <div class="ml-3 flex-grow-1">
                                    <h6 class="mb-0 small font-weight-bold text-dark text-truncate" style="max-width: 180px;"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                </div>
                                <div class="text-right">
                                    <span class="small font-weight-bold"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>
                        <?php 
                            endforeach; 
                        endif; 
                        ?>
                    </div>

                    <div class="p-4 border-top">
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Tạm tính:</span>
                            <span><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success font-weight-bold">Miễn phí</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="h5 font-weight-bold text-dark mb-0">Tổng cộng:</span>
                            <span class="h4 font-weight-bold text-danger mb-0"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 p-2 text-center text-muted small">
                <i class="fas fa-lock mr-1"></i> Thông tin của bạn được bảo mật 100%
            </div>
        </div>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .input-group-text { border-color: #ced4da; }
    .form-control:focus { border-color: #007bff; box-shadow: none; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>

<?php include 'app/views/shares/footer.php'; ?>