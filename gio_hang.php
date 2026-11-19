<?php
session_start();

// TRẠM GÁC: Kiểm tra khách đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Vui lòng đăng nhập để xem giỏ hàng của bạn!');
            window.location.href = 'login.php';
          </script>";
    exit(); // Chốt chặn, không cho chạy phần code hiển thị giỏ hàng bên dưới
}

// Lấy dữ liệu giỏ hàng, nếu không có thì là mảng rỗng
$cart = isset($_SESSION['gio_hang']) ? $_SESSION['gio_hang'] : [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f4f6f8; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #C92127; border-bottom: 2px solid #C92127; padding-bottom: 10px; margin-top: 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #eee; padding: 10px; text-align: left; border-bottom: 2px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #ddd; vertical-align: middle; }
        
        .img-cart { width: 60px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; }
        .item-name { font-weight: bold; color: #333; }
        
        /* CSS cho nút số lượng */
        .qty-box { display: flex; align-items: center; gap: 5px; }
        .btn-qty { 
            display: inline-block; width: 25px; height: 25px; line-height: 25px; 
            text-align: center; background: #eee; text-decoration: none; color: #333; font-weight: bold; border-radius: 3px; border: 1px solid #ccc;
        }
        .btn-qty:hover { background: #ddd; }
        .qty-number { font-weight: bold; padding: 0 8px; min-width: 20px; text-align: center; }

        /* Nút điều hướng */
        .actions { margin-top: 30px; display: flex; justify-content: space-between; align-items: center; }
        .btn-home { text-decoration: none; background: #555; color: white; padding: 12px 20px; border-radius: 4px; font-weight: 500; transition: 0.2s; }
        .btn-home:hover { background: #333; }
        
        .btn-checkout { text-decoration: none; background: #C92127; color: white; padding: 12px 25px; border-radius: 4px; font-weight: bold; font-size: 16px; transition: 0.2s; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
        .btn-checkout:hover { background: #a0151a; transform: translateY(-2px); }
        
        .empty-cart { text-align: center; padding: 60px 20px; color: #777; }
        .xoa-btn { color: #d9534f; text-decoration: none; font-size: 13px; border: 1px solid #d9534f; padding: 4px 10px; border-radius: 4px; transition: 0.2s; }
        .xoa-btn:hover { background: #d9534f; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2>🛒 GIỎ HÀNG CỦA BẠN</h2>

    <?php if(count($cart) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 45%;">Sản phẩm</th>
                    <th style="width: 15%;">Giá</th>
                    <th style="width: 15%;">Số lượng</th>
                    <th style="width: 15%;">Thành tiền</th>
                    <th style="width: 10%;">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tong_tien = 0;
                foreach($cart as $id => $item): 
                    $thanh_tien = $item['gia'] * $item['so_luong'];
                    $tong_tien += $thanh_tien;
                ?>
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:15px;">
                            <img src="images/<?php echo $item['hinh']; ?>" class="img-cart">
                            <span class="item-name"><?php echo $item['ten_sach']; ?></span>
                        </div>
                    </td>
                    <td><?php echo number_format($item['gia'], 0, ',', '.'); ?> đ</td>
                    
                    <td>
                        <div class="qty-box">
                            <a href="xu_ly_so_luong.php?id=<?php echo $id; ?>&kieu=giam" class="btn-qty">-</a>
                            <span class="qty-number"><?php echo $item['so_luong']; ?></span>
                            <a href="xu_ly_so_luong.php?id=<?php echo $id; ?>&kieu=tang" class="btn-qty">+</a>
                        </div>
                    </td>
                    
                    <td style="color:#C92127; font-weight:bold;"><?php echo number_format($thanh_tien, 0, ',', '.'); ?> đ</td>
                    
                    <td>
                        <a href="xoa_gio_hang.php?id=<?php echo $id; ?>" class="xoa-btn" onclick="return confirm('Bạn có chắc muốn xóa cuốn sách này không?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <tr style="background-color: #f9f9f9;">
                    <td colspan="3" style="text-align:right; font-weight:bold; font-size:18px; padding-top: 20px;">TỔNG CỘNG:</td>
                    <td colspan="2" style="color:#C92127; font-weight:bold; font-size:22px; padding-top: 20px;"><?php echo number_format($tong_tien, 0, ',', '.'); ?> đ</td>
                </tr>
            </tbody>
        </table>
        
        <div class="actions">
            <a href="index.php" class="btn-home">← Tiếp tục mua sắm</a>
            
            <a href="form_thanh_toan.php" class="btn-checkout">Tiến hành Thanh toán ➔</a>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <h3 style="margin-bottom: 10px;">Giỏ hàng đang trống!</h3>
            <p style="margin-bottom: 30px;">Có vẻ như bạn chưa chọn cuốn sách nào.</p>
            <a href="index.php" class="btn-checkout">Quay lại trang chủ</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>