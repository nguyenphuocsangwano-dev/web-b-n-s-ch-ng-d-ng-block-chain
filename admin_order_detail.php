<?php
session_start();
include 'config.php';

$don_hang_id = $_GET['id'];

// Lấy thông tin chung của đơn
$sql_don = "SELECT * FROM don_hang WHERE id = $don_hang_id";
$res_don = mysqli_query($conn, $sql_don);
$don = mysqli_fetch_assoc($res_don);

// Lấy chi tiết các món hàng trong đơn
$sql_ct = "SELECT * FROM chi_tiet_don_hang WHERE don_hang_id = $don_hang_id";
$res_ct = mysqli_query($conn, $sql_ct);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?php echo $don_hang_id; ?></title>
    <style>
        body { font-family: 'Roboto', sans-serif; background: #f4f6f8; padding: 20px; }
        .detail-container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-size: 20px; color: #C92127; font-weight: bold; text-align: right; margin-top: 20px; }
    </style>
</head>
<body>

<div class="detail-container">
    <h2>CHI TIẾT ĐƠN HÀNG #<?php echo $don_hang_id; ?></h2>
    
    <div class="info-box">
        <p>👤 <b>Người nhận:</b> <?php echo $don['ho_ten']; ?></p>
        <p>📞 <b>Số điện thoại:</b> <?php echo $don['dien_thoai']; ?></p>
        <p>🏠 <b>Địa chỉ:</b> <?php echo $don['dia_chi']; ?></p>
        <p>💳 <b>Hình thức:</b> <?php echo $don['phuong_thuc_tt']; ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tên sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php while($item = mysqli_fetch_assoc($res_ct)): ?>
            <tr>
                <td><?php echo $item['ten_sach']; ?></td>
                <td><?php echo number_format($item['gia'], 0, ',', '.'); ?> đ</td>
                <td><?php echo $item['so_luong']; ?></td>
                <td><?php echo number_format($item['gia'] * $item['so_luong'], 0, ',', '.'); ?> đ</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="total"> TỔNG CỘNG: <?php echo number_format($don['tong_tien'], 0, ',', '.'); ?> đ</div>
    
    <br>
    <a href="admin_orders.php">← Quay lại danh sách đơn</a>
</div>

</body>
</html>