<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            
            <div class="card shadow-sm border-0 p-4 p-md-5 bg-white" style="border-radius: 16px;">
                <div class="card-body">
                    
                    <div class="text-success mb-4 animate-bounce">
                        <i class="fas fa-check-circle fa-5x shadow-sm rounded-circle p-2 bg-light"></i>
                    </div>
                    
                    <h2 class="font-weight-bold text-dark mb-3">Đặt Hàng Thành Công!</h2>
                    
                    <p class="text-muted lead mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                        Cảm ơn bạn đã tin tưởng và mua sắm tại <strong class="text-primary">TechStore</strong>.<br>
                        Đơn hàng của bạn đã được hệ thống tiếp nhận và đang trong quá trình xử lý bàn giao cho đơn vị vận chuyển.
                    </p>
                    
                    <div class="bg-light p-3 rounded mb-4 text-left small border-left" style="border-left: 4px solid #28a745 !important;">
                        <h6 class="font-weight-bold text-dark mb-1"><i class="fas fa-info-circle mr-2 text-success"></i>Lưu ý nhỏ:</h6>
                        <ul class="mb-0 pl-3 text-muted">
                            <li>Nhân viên tư vấn sẽ liên hệ xác nhận qua số điện thoại của bạn trong ít phút.</li>
                            <li>Vui lòng giữ máy để không bỏ lỡ cuộc gọi giao hàng nhé!</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 mt-4">
                        <a href="/Product/shop" class="btn btn-success btn-lg px-4 py-2.5 font-weight-bold shadow-sm" style="border-radius: 8px; font-size: 1rem;">
                            <i class="fas fa-shopping-bag mr-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
    .animate-bounce { animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
</style>

<?php include 'app/views/shares/footer.php'; ?>