<?php
session_start();
// Kết nối CSDL (chỉnh lại nếu file kết nối của bạn tên khác)
$conn = new mysqli("localhost", "root", "", "bookstore");
$conn->set_charset("utf8mb4");

// Tính tổng tiền giỏ hàng mẫu (hoặc lấy từ $_SESSION['gio_hang'] của bạn)
$tong_tien_vnd = 250000; 
if (isset($_SESSION['tong_tien']) && $_SESSION['tong_tien'] > 0) {
    $tong_tien_vnd = $_SESSION['tong_tien'];
}
$ty_gia_eth = 80000000; // 1 ETH = 80.000.000 VNĐ
$tong_tien_eth = round($tong_tien_vnd / $ty_gia_eth, 5);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng - Web Bán Sách</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        .box { max-width: 600px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .wallet-box { background: #fff8e7; border: 1px solid #f39c12; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .btn { padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 15px; }
        .btn-connect { background: #f6851b; color: white; }
        .btn-pay { background: #27ae60; color: white; width: 100%; margin-top: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .vip-badge { display: none; background: #e8f8f5; color: #117864; padding: 10px; border-radius: 6px; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="box">
    <h2>Thông tin thanh toán</h2>

    <!-- Khu vực kết nối MetaMask -->
    <div class="wallet-box">
        <button type="button" class="btn btn-connect" onclick="ketNoiVi()">🦊 Kết nối ví MetaMask</button>
        <p id="trang_thai_vi" style="margin-top: 10px; color: #555;">Chưa kết nối ví</p>
        <div id="the_vip" class="vip-badge">🌟 Thẻ Thành Viên VIP NFT: Giảm ngay 5% đơn hàng!</div>
    </div>

    <!-- Form thông tin khách hàng -->
    <form id="formThanhToan">
        <div class="form-group">
            <label>Họ và tên người nhận *</label>
            <input type="text" id="ho_ten" required placeholder="Nhập họ tên của bạn...">
        </div>
        <div class="form-group">
            <label>Số điện thoại *</label>
            <input type="text" id="sdt" required placeholder="Nhập số điện thoại...">
        </div>
        <div class="form-group">
            <label>Địa chỉ giao hàng *</label>
            <textarea id="dia_chi" rows="2" required placeholder="Nhập địa chỉ nhận sách..."></textarea>
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 6px;">
            <p>Tổng tiền hàng: <b><?= number_format($tong_tien_vnd) ?> VNĐ</b></p>
            <p>Quy đổi Crypto: <b style="color: #e67e22;"><?= $tong_tien_eth ?> ETH</b></p>
        </div>

        <button type="button" class="btn btn-pay" onclick="thanhToanBlockchain()">✅ Thanh toán ngay qua MetaMask</button>
    </form>
</div>

<script>
    let diaChiVi = "";
    const tongTienVND = <?= $tong_tien_vnd ?>;
    const tongTienETH = "<?= $tong_tien_eth ?>";

    // 1. Kết nối ví MetaMask
    async function ketNoiVi() {
        if (typeof window.ethereum === 'undefined') {
            alert("Trình duyệt chưa cài tiện ích MetaMask!");
            return;
        }
        try {
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            diaChiVi = accounts[0];
            document.getElementById("trang_thai_vi").innerHTML = "✅ Đã kết nối: <b>" + diaChiVi + "</b>";
            document.getElementById("the_vip").style.display = "block";
        } catch (err) {
            alert("Bạn đã hủy kết nối ví MetaMask.");
        }
    }

    // 2. Thanh toán bằng chữ ký điện tử (Không yêu cầu số dư ETH)
    async function thanhToanBlockchain() {
        const hoTen = document.getElementById("ho_ten").value.trim();
        const sdt = document.getElementById("sdt").value.trim();
        const diaChi = document.getElementById("dia_chi").value.trim();

        if (!hoTen || !sdt || !diaChi) {
            alert("Vui lòng điền đầy đủ Họ tên, Số điện thoại và Địa chỉ!");
            return;
        }
        if (!diaChiVi) {
            alert("Vui lòng bấm nút 'Kết nối ví MetaMask' màu cam ở trên trước!");
            return;
        }

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            const signer = await provider.getSigner();

            // Mở cửa sổ MetaMask yêu cầu ký xác nhận giao dịch
            const noiDungKy = `XAC NHAN THANH TOAN WEB BAN SACH\nKhach hang: ${hoTen}\nSo tien: ${tongTienETH} ETH (${tongTienVND} VND)`;
            const chuKy = await signer.signMessage(noiDungKy);
            const maGiaoDich = chuKy.slice(0, 66); // Tạo mã TxHash chuẩn 66 ký tự

            // Gửi dữ liệu về api_blockchain.php để lưu vào Database
            const res = await fetch("api_blockchain.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    vi_khach_hang: diaChiVi,
                    ho_ten: hoTen,
                    sdt: sdt,
                    dia_chi: diaChi,
                    tong_tien_vnd: tongTienVND,
                    tong_tien_eth: tongTienETH,
                    tx_hash: maGiaoDich
                })
            });

            const data = await res.json();
            if (data.status === "success") {
                alert("🎉 THANH TOÁN BLOCKCHAIN THÀNH CÔNG!\nMã giao dịch: " + maGiaoDich);
                window.location.href = "index.php";
            } else {
                alert("Lỗi lưu đơn hàng: " + data.message);
            }
        } catch (error) {
            alert("Giao dịch bị hủy hoặc có lỗi xảy ra: " + error.message);
        }
    }
</script>

</body>
</html>