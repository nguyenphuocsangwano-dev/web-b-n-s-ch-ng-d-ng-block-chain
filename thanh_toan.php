<?php
session_start();

// Xóa sạch giỏ hàng
unset($_SESSION['gio_hang']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán thành công</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding-top: 50px; background: #f4f6f8; }
        .success-box { background: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { color: #28a745; }
        p { font-size: 18px; color: #555; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #C92127; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="success-box">
        <h1>🎉 ĐẶT HÀNG THÀNH CÔNG!</h1>
        <p>Cảm ơn bạn đã mua sách tại BookStore.</p>
        <p>Đơn hàng của bạn đang được xử lý và sẽ giao sớm nhất.</p>
        <a href="index.php">Tiếp tục mua sắm</a>
    </div>
</body>
</html>