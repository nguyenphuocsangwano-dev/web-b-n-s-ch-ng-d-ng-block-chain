<?php
session_start();
$so_luong_gio_hang = isset($_SESSION['gio_hang']) ? count($_SESSION['gio_hang']) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chính sách vận chuyển - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* (Copy CSS giống file Giới thiệu ở trên hoặc dùng file css chung) */
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
        h3 { margin-top: 25px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f9f9f9; color: #C92127; }
        
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
            <h1>Chính Sách Vận Chuyển</h1>
            
            <h3>1. Phí vận chuyển</h3>
            <p>BookStore áp dụng chính sách phí vận chuyển linh hoạt dựa trên giá trị đơn hàng và khu vực giao hàng:</p>
            <table>
                <tr>
                    <th>Giá trị đơn hàng</th>
                    <th>Khu vực</th>
                    <th>Phí Ship</th>
                </tr>
                <tr>
                    <td>Dưới 300.000đ</td>
                    <td>Toàn quốc</td>
                    <td>30.000đ</td>
                </tr>
                <tr>
                    <td>Từ 300.000đ trở lên</td>
                    <td>Nội thành Cần Thơ</td>
                    <td><strong>Miễn phí</strong></td>
                </tr>
                <tr>
                    <td>Từ 500.000đ trở lên</td>
                    <td>Toàn quốc</td>
                    <td><strong>Miễn phí</strong></td>
                </tr>
            </table>

            <h3>2. Thời gian giao hàng</h3>
            <ul>
                <li><strong>Nội thành:</strong> 1 - 2 ngày làm việc.</li>
                <li><strong>Tỉnh/Thành khác:</strong> 3 - 5 ngày làm việc.</li>
            </ul>
            <p><em>Lưu ý: Thời gian giao hàng không tính Thứ 7, Chủ nhật và các ngày Lễ, Tết.</em></p>

            <h3>3. Kiểm tra hàng</h3>
            <p>Khách hàng được quyền kiểm tra tình trạng bên ngoài của hộp hàng (nguyên vẹn, không móp méo) trước khi nhận. Nếu phát hiện hư hỏng, quý khách vui lòng từ chối nhận hàng và báo ngay cho chúng tôi.</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="copyright">© 2024 BookStore Project.</div>
        </div>
    </footer>

</body>
</html>