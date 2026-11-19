<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookstore");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL: " . $conn->connect_error);
}

$ten_khach = isset($_SESSION['username']) ? $_SESSION['username'] : 'Khách hàng Web3';
$vi_tim_kiem = isset($_GET['vi']) ? $conn->real_escape_string(trim($_GET['vi'])) : '';

$thong_tin_vip = null;
if ($vi_tim_kiem !== '') {
    $sql_don = "SELECT * FROM don_hang_crypto WHERE vi_khach_hang = '$vi_tim_kiem' ORDER BY id DESC";
    $res_vip = $conn->query("SELECT * FROM vi_thanh_vien_nft WHERE dia_chi_vi = '$vi_tim_kiem'");
    if ($res_vip && $res_vip->num_rows > 0) {
        $thong_tin_vip = $res_vip->fetch_assoc();
    }
} else {
    $sql_don = "SELECT * FROM don_hang_crypto ORDER BY id DESC";
}

$result_don = $conn->query($sql_don);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cổng Khách Hàng - Web Bán Sách Blockchain</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 25px; color: #333; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 25px 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .top-nav { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .user-info { font-size: 18px; font-weight: bold; color: #2c3e50; }
        .btn { padding: 10px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-orange { background: #f6851b; color: #fff; }
        .btn-green { background: #27ae60; color: #fff; }
        .btn-dark { background: #34495e; color: #fff; }
        .btn-gray { background: #ecf0f1; color: #2c3e50; }
        .vip-banner { background: linear-gradient(135deg, #0f9b0f, #117864); color: white; padding: 18px 22px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px; }
        th, td { padding: 12px 10px; border: 1px solid #e0e0e0; text-align: left; }
        th { background: #2c3e50; color: white; }
        tr:nth-child(even) { background: #f9fbfd; }
        .badge-paid { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; }
        .tx-hash { font-family: monospace; background: #eef2f7; padding: 4px 6px; border-radius: 4px; font-size: 12px; color: #2980b9; }
    </style>
</head>
<body>

<div class="container">
    <div class="top-nav">
        <div class="user-info">👤 Xin chào, <?= htmlspecialchars($ten_khach) ?></div>
        <div>
            <a href="form_thanh_toan.php" class="btn btn-green">💳 Đặt & Thanh toán MetaMask</a>
            <button type="button" class="btn btn-orange" onclick="locTheoVi()">🦊 Kết nối ví xem đơn của tôi</button>
            <?php if ($vi_tim_kiem !== ''): ?>
                <a href="khach_hang.php" class="btn btn-gray">Hiện tất cả đơn</a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-dark">🏠 Trang chủ</a>
        </div>
    </div>

    <?php if ($vi_tim_kiem !== ''): ?>
        <p style="background: #fff8e7; padding: 10px 15px; border-left: 4px solid #f39c12; border-radius: 4px;">
            Đang lọc dữ liệu theo địa chỉ ví: <b><?= htmlspecialchars($vi_tim_kiem) ?></b>
        </p>
    <?php endif; ?>

    <?php if ($thong_tin_vip): ?>
        <div class="vip-banner">
            <div>
                <h3 style="margin: 0 0 6px 0;">🌟 THẺ THÀNH VIÊN VIP NFT: <?= htmlspecialchars($thong_tin_vip['hang_the']) ?></h3>
                <span>Chủ sở hữu ví: <b><?= htmlspecialchars($thong_tin_vip['dia_chi_vi']) ?></b></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px; opacity: 0.9;">Điểm tích lũy Blockchain</span><br>
                <b style="font-size: 26px;"><?= number_format($thong_tin_vip['diem_tich_luy']) ?> điểm</b>
            </div>
        </div>
    <?php endif; ?>

    <h3 style="color: #2c3e50; margin-bottom: 5px;">📦 Lịch sử đơn hàng đã đặt & thanh toán Crypto</h3>

    <table>
        <thead>
            <tr>
                <th>Mã ĐH</th>
                <th>Người nhận</th>
                <th>Địa chỉ giao hàng</th>
                <th>Tổng tiền</th>
                <th>Mã giao dịch (TxHash)</th>
                <th>Trạng thái</th>
                <th>Thời gian đặt</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_don && $result_don->num_rows > 0): ?>
                <?php while ($row = $result_don->fetch_assoc()): ?>
                    <tr>
                        <td><b>#<?= $row['id'] ?></b></td>
                        <td>
                            <b><?= htmlspecialchars($row['ho_ten']) ?></b><br>
                            <small>SĐT: <?= htmlspecialchars($row['sdt']) ?></small><br>
                            <small style="color: #7f8c8d;">Ví: <?= substr($row['vi_khach_hang'], 0, 8) ?>...<?= substr($row['vi_khach_hang'], -4) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['dia_chi']) ?></td>
                        <td>
                            <b><?= number_format($row['tong_tien_vnd']) ?> VNĐ</b><br>
                            <span style="color: #e67e22; font-weight: bold;"><?= rtrim(rtrim($row['tong_tien_eth'], '0'), '.') ?> ETH</span>
                        </td>
                        <td>
                            <span class="tx-hash" title="<?= htmlspecialchars($row['tx_hash']) ?>">
                                <?= substr($row['tx_hash'], 0, 12) ?>...<?= substr($row['tx_hash'], -6) ?>
                            </span>
                        </td>
                        <td><span class="badge-paid">✔ Đã thanh toán Crypto</span></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['ngay_tao'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #7f8c8d;">
                        Chưa có đơn hàng nào được ghi nhận cho ví này.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    async function locTheoVi() {
        if (typeof window.ethereum === 'undefined') {
            alert("Trình duyệt chưa cài đặt ví MetaMask!");
            return;
        }
        try {
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            if (accounts.length > 0) {
                window.location.href = "khach_hang.php?vi=" + accounts[0];
            }
        } catch (err) {
            alert("Bạn đã hủy kết nối ví MetaMask.");
        }
    }
</script>

</body>
</html>
