<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bookstore");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Lỗi kết nối CSDL: " . $conn->connect_error);
}

// Lấy địa chỉ ví từ tham số URL (nếu khách kết nối ví) hoặc hiển thị tất cả đơn gần nhất để dễ kiểm tra
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
    <title>Lịch sử đơn hàng & Thanh toán Blockchain</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 30px; color: #333; }
        .container { max-width: 1050px; margin: auto; background: #fff; padding: 25px 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header-bar { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        h2 { margin: 0; color: #2c3e50; }
        .btn { padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-connect { background: #f6851b; color: #fff; }
        .btn-home { background: #34495e; color: #fff; }
        .btn-all { background: #ecf0f1; color: #2c3e50; }
        .vip-card { background: linear-gradient(135deg, #117864, #1abc9c); color: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 12px 10px; border: 1px solid #e0e0e0; text-align: left; }
        th { background: #2c3e50; color: white; }
        tr:nth-child(even) { background: #f9fbfd; }
        .badge-paid { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; }
        .tx-hash { font-family: monospace; background: #f1f2f6; padding: 4px 6px; border-radius: 4px; font-size: 12px; color: #2980b9; word-break: break-all; max-width: 180px; display: inline-block; }
        .empty-box { text-align: center; padding: 40px; color: #7f8c8d; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-bar">
        <h2>📦 Đơn hàng đã đặt & Thanh toán</h2>
        <div>
            <button type="button" class="btn btn-connect" onclick="locTheoViMetaMask()">🦊 Lọc theo ví MetaMask của tôi</button>
            <?php if ($vi_tim_kiem !== ''): ?>
                <a href="don_hang_cua_toi.php" class="btn btn-all">Xem tất cả</a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-home">🏠 Trang chủ</a>
        </div>
    </div>

    <?php if ($vi_tim_kiem !== ''): ?>
        <p>Đang hiển thị đơn hàng của ví: <b><?= htmlspecialchars($vi_tim_kiem) ?></b></p>
    <?php endif; ?>

    <?php if ($thong_tin_vip): ?>
        <div class="vip-card">
            <div>
                <h3 style="margin: 0 0 5px 0;">🌟 Thẻ Thành Viên VIP NFT: <?= htmlspecialchars($thong_tin_vip['hang_the']) ?></h3>
                <span>Địa chỉ ví sở hữu: <b><?= htmlspecialchars($thong_tin_vip['dia_chi_vi']) ?></b></span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 13px;">Điểm tích lũy</span><br>
                <b style="font-size: 24px;"><?= number_format($thong_tin_vip['diem_tich_luy']) ?> điểm</b>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($result_don && $result_don->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Người nhận</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Tổng tiền</th>
                    <th>Mã giao dịch (TxHash)</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_don->fetch_assoc()): ?>
                    <tr>
                        <td><b>#<?= $row['id'] ?></b></td>
                        <td>
                            <b><?= htmlspecialchars($row['ho_ten']) ?></b><br>
                            <small>SĐT: <?= htmlspecialchars($row['sdt']) ?></small><br>
                            <small style="color:#7f8c8d;">Ví: <?= substr($row['vi_khach_hang'], 0, 8) ?>...<?= substr($row['vi_khach_hang'], -4) ?></small>
                        </td>
                        <td><?= htmlspecialchars($row['dia_chi']) ?></td>
                        <td>
                            <b><?= number_format($row['tong_tien_vnd']) ?> VNĐ</b><br>
                            <span style="color: #e67e22; font-weight: bold;"><?= rtrim(rtrim($row['tong_tien_eth'], '0'), '.') ?> ETH</span>
                        </td>
                        <td>
                            <span class="tx-hash" title="<?= htmlspecialchars($row['tx_hash']) ?>">
                                <?= substr($row['tx_hash'], 0, 14) ?>...<?= substr($row['tx_hash'], -8) ?>
                            </span>
                        </td>
                        <td><span class="badge-paid">✔ Đã thanh toán Crypto</span></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['ngay_tao'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-box">
            <p>Chưa có đơn hàng nào được ghi nhận.</p>
            <a href="form_thanh_toan.php" class="btn btn-connect">Đi tới trang đặt hàng ngay</a>
        </div>
    <?php endif; ?>
</div>

<script>
    async function locTheoViMetaMask() {
        if (typeof window.ethereum === 'undefined') {
            alert("Trình duyệt chưa cài đặt tiện ích MetaMask!");
            return;
        }
        try {
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            if (accounts.length > 0) {
                window.location.href = "don_hang_cua_toi.php?vi=" + accounts[0];
            }
        } catch (err) {
            alert("Bạn đã hủy kết nối ví MetaMask.");
        }
    }
</script>

</body>
</html>
