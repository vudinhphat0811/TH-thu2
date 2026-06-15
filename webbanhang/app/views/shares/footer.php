</div> <footer class="bg-dark text-light mt-5 pt-5 border-top border-secondary">
    <div class="container pb-4">
        <div class="row g-4">
            
            <div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
                <h5 class="text-uppercase text-white font-weight-bold mb-3">
                    <i class="fas fa-laptop-code text-success mr-2"></i>TechStore
                </h5>
                <p class="text-muted small" style="line-height: 1.6; max-width: 380px;">
                    Hệ thống quản lý và phân phối sản phẩm công nghệ chính hãng. Mang lại trải nghiệm mua sắm hiện đại, an toàn và tiện lợi nhất cho khách hàng.
                </p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase text-white font-weight-bold mb-3">Liên kết nhanh</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="/Product/shop" class="text-muted text-decoration-none hover-white small">
                            <i class="fas fa-shopping-bag mr-2 text-success"></i>Cửa hàng mua sắm
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="mb-2">
                            <a href="/Product" class="text-muted text-decoration-none hover-white small">
                                <i class="fas fa-boxes mr-2 text-info"></i>Danh sách sản phẩm (Admin)
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/Product/add" class="text-muted text-decoration-none hover-white small">
                                <i class="fas fa-plus-circle mr-2 text-warning"></i>Thêm sản phẩm mới
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="mb-2">
                            <a href="/Product/cart" class="text-muted text-decoration-none hover-white small">
                                <i class="fas fa-shopping-cart mr-2 text-secondary"></i>Giỏ hàng của bạn
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/Auth/profile" class="text-muted text-decoration-none hover-white small">
                                <i class="fas fa-user-cog mr-2 text-secondary"></i>Quản lý tài khoản
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-0">
                <h5 class="text-uppercase text-white font-weight-bold mb-3">Kết nối với chúng tôi</h5>
                <p class="text-muted small mb-3">Theo dõi TechStore để cập nhật khuyến mãi mới nhất.</p>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle mr-2 social-icon d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle mr-2 social-icon d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle social-icon d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="text-center p-3 text-muted small" style="background-color: rgba(0, 0, 0, 0.2); border-top: 1px solid rgba(255, 255, 255, 0.05);">
        © 2026 <span class="text-white font-weight-bold">TechStore</span>. All rights reserved. Designed with Bootstrap.
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>

<style>
    /* CSS hiệu ứng tương tác Link */
    .hover-white:hover {
        color: #ffffff !important;
        padding-left: 4px;
        transition: all 0.2s ease-in-out;
    }
    /* CSS hiệu ứng tương tác Icon mạng xã hội tròn */
    .social-icon:hover {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: white !important;
        transform: translateY(-3px);
        transition: all 0.2s ease-in-out;
    }
</style>
</body>
</html>