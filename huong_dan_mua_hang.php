<?php
session_start();
$so_luong_gio_hang = isset($_SESSION['gio_hang']) ? count($_SESSION['gio_hang']) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hướng dẫn mua hàng - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Roboto', sans-serif; background: #f4f6f8; color: #333; display: flex; flex-direction: column; }
        a { text-decoration: none; transition: 0.2s; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .header-main { background: white; padding: 15px 0; border-bottom: 1px solid #eee; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        .brand { font-size: 28px; font-weight: 900; color: #C92127; }
        .user-actions { display: flex; gap: 20px; } .user-actions a { color: #555; font-size: 13px; }
        
        .page-content { flex: 1; padding: 40px; background: white; margin-top: 20px; border-radius: 8px; }
        h1 { color: #C92127; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        
        .step { margin-bottom: 30px; }
        .step-title { font-weight: bold; font-size: 18px; color: #333; margin-bottom: 10px; }
        .step-num { background: #C92127; color: white; padding: 2px 8px; border-radius: 50%; font-size: 14px; margin-right: 10px; }
        
        footer { background-color: white; border-top: 4px solid #C92127; padding: 40px 0 20px; margin-top: auto; }
        .copyright { text-align: center; margin-top: 30px; font-size: 13px; color: #999; }
    </style>
</head>
<body>

    <div class="header-main">
        <div class="container header-flex">
            <a href="index.php" class="brand">bookstore</a>
            <div class="user-actions">
                <a href="index.php">🏠 Trang chủ</a>
                <a href="gio_hang.php">🛒 Giỏ hàng (<?php echo $so_luong_gio_hang; ?>)</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-content">
            <h1>Hướng Dẫn Mua Hàng</h1>
            
            <div class="step">
                <div class="step-title"><span class="step-num">1</span>Tìm kiếm sản phẩm</div>
                <p>Bạn có thể tìm sản phẩm bằng cách gõ tên sách vào thanh tìm kiếm hoặc duyệt qua các danh mục (Truyện, Sách IT, Sách Hay...) trên thanh menu.</p>
            </div>

            <div class="step">
                <div class="step-title"><span class="step-num">2</span>Thêm vào giỏ hàng</div>
                <p>Tại trang chi tiết sản phẩm hoặc trang danh sách, bạn bấm nút <strong>"Thêm vào giỏ"</strong>. Sản phẩm sẽ được đưa vào giỏ hàng của bạn.</p>
            </div>

            <div class="step">
                <div class="step-title"><span class="step-num">3</span>Kiểm tra giỏ hàng</div>
                <p>Bấm vào biểu tượng <strong>🛒 Giỏ hàng</strong> ở góc trên bên phải để xem lại các sản phẩm đã chọn. Tại đây bạn có thể tăng/giảm số lượng hoặc xóa sản phẩm.</p>
            </div>

            <div class="step">
                <div class="step-title"><span class="step-num">4</span>Thanh toán</div>
                <p>Bấm nút <strong>"Tiến hành Thanh Toán"</strong>. Điền đầy đủ thông tin giao hàng (Họ tên, SĐT, Địa chỉ) và chọn phương thức thanh toán (COD hoặc Chuyển khoản).</p>
            </div>

            <div class="step">
                <div class="step-title"><span class="step-num">5</span>Hoàn tất</div>
                <p>Bấm <strong>"Xác nhận đặt hàng"</strong>. Hệ thống sẽ thông báo đặt hàng thành công và gửi mã đơn hàng cho bạn.</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="copyright">© 2024 BookStore Project.</div>
        </div>
    </footer>

</body>
</html>