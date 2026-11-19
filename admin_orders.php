<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookstore");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL: " . $conn->connect_error);
}

// Truy vấn toàn bộ đơn hàng thanh toán Blockchain từ mới nhất đến cũ nhất
$sql = "SELECT * FROM don_hang_crypto ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 30px; color: #333; }
        .container { max-width: 1150px; margin: auto; background: #fff; padding: 25px 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        h2 { color: #c0392b; border-bottom: 2px solid #c0392b; padding-bottom: 12px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        th, td { padding: 12px 10px; border: 1px solid #e0e0e0; text-align: left; vertical-align: middle; }
        th { background: #f1f2f6; color: #2c3e50; font-weight: bold; }
        tr:nth-child(even) { background: #fafafa; }
        .badge-paid { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; }
        .tx-hash { font-family: monospace; background: #eef2f7; padding: 3px 6px; border-radius: 4px; font-size: 12px; color: #2980b9; display: inline-block; margin-top: 4px; }
        .btn-back { display: inline-block; margin-top: 20px; color: #4a148c; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>📦 DANH SÁCH ĐƠN HÀNG MỚI</h2>

    <table>
        <thead>
            <tr>
                <th>Mã Đơn</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Địa chỉ giao hàng</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Ngày đặt</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><b>#<?= $row['id'] ?></b></td>
                        <td>
                            <b><?= htmlspecialchars($row['ho_ten']) ?></b><br>
                            <small style="color: #7f8c8d;">Ví: <?= substr($row['vi_khach_hang'], 0, 8) ?>...<?= substr($row['vi_khach_hang'], -4) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['sdt']) ?></td>
                        <td><?= htmlspecialchars($row['dia_chi']) ?></td>
                        <td>
                            <b style="color: #c0392b;"><?= number_format($row['tong_tien_vnd']) ?> đ</b><br>
                            <small style="color: #e67e22; font-weight: bold;"><?= rtrim(rtrim($row['tong_tien_eth'], '0'), '.') ?> ETH</small>
                        </td>
                        <td>
                            <span class="badge-paid">✔ Đã thanh toán MetaMask</span><br>
                            <span class="tx-hash" title="<?= htmlspecialchars($row['tx_hash']) ?>">
                                Tx: <?= substr($row['tx_hash'], 0, 12) ?>...<?= substr($row['tx_hash'], -6) ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($row['ngay_tao'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 25px; color: #7f8c8d;">Chưa có đơn hàng nào được đặt.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="admin.php" class="btn-back">← Quay lại trang Admin</a>
</div>

</body>
</html>