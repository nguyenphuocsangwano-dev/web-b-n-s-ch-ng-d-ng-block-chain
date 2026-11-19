<?php
session_start();
include 'config.php'; // Đảm bảo ní đã có file này để kết nối Database

// 1. TRẠM GÁC: Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 2. Kiểm tra xem khách có nhấn nút "Xác nhận đặt hàng" không
if (isset($_POST['btn_dathang'])) {
    
    // NHẬN DỮ LIỆU TỪ FORM (Dùng mysqli_real_escape_string để chống hack)
    $username = $_SESSION['username'];
    $hoten = mysqli_real_escape_string($conn, $_POST['hoten']);
    $sdt = mysqli_real_escape_string($conn, $_POST['sdt']);
    $diachi = mysqli_real_escape_string($conn, $_POST['diachi']);
    $tongtien = $_POST['tongtien'];
    $phuong_thuc = mysqli_real_escape_string($conn, $_POST['phuong_thuc']); 

    // --- BƯỚC LƯU VÀO DATABASE (QUAN TRỌNG NHẤT) ---
    // Lưu thông tin chung vào bảng don_hang
    $sql_don = "INSERT INTO don_hang (username, ho_ten, dien_thoai, dia_chi, tong_tien, phuong_thuc_tt) 
                VALUES ('$username', '$hoten', '$sdt', '$diachi', $tongtien, '$phuong_thuc')";
    
    if (mysqli_query($conn, $sql_don)) {
        $don_hang_id = mysqli_insert_id($conn); // Lấy ID của đơn hàng vừa tạo

        // Lưu từng cuốn sách trong giỏ vào bảng chi_tiet_don_hang
        foreach ($_SESSION['gio_hang'] as $sach_id => $item) {
            $ten_sach = mysqli_real_escape_string($conn, $item['ten_sach']);
            $gia = $item['gia'];
            $so_luong = $item['so_luong'];
            
            $sql_ct = "INSERT INTO chi_tiet_don_hang (don_hang_id, sach_id, ten_sach, gia, so_luong) 
                       VALUES ($don_hang_id, $sach_id, '$ten_sach', $gia, $so_luong)";
            mysqli_query($conn, $sql_ct);
        }
    } else {
        die("Lỗi hệ thống: " . mysqli_error($conn));
    }

    // --- BƯỚC CHUẨN BỊ GIAO DIỆN HIỂN THỊ (CODE QR CỦA NÍ) ---
    $html_ket_qua = ""; 

    if ($phuong_thuc == 'COD') {
        $tieu_de = "THANH TOÁN KHI NHẬN HÀNG";
        $html_ket_qua = "<p class='note'>Shipper sẽ giao hàng đến địa chỉ của bạn.<br>Vui lòng chuẩn bị số tiền <b>".number_format($tongtien, 0, ',', '.')." đ</b> để thanh toán.</p>";
    
    } else {
        $tieu_de = "QUÉT MÃ QR ĐỂ THANH TOÁN";
        
        $ngan_hang = 'MB';             
        $stk = '0367306447';           
        $chu_tk = 'LE TUAN KIET';      
        // Nội dung CK bao gồm mã đơn hàng để dễ quản lý
        $noi_dung = "Thanh toan don " . $don_hang_id . " sdt " . $sdt; 
        
        $link_qr = "https://img.vietqr.io/image/$ngan_hang-$stk-compact.jpg?amount=$tongtien&addInfo=".urlencode($noi_dung)."&accountName=".urlencode($chu_tk);
        
        $html_ket_qua = "
            <div style='margin: 20px 0;'>
                <img src='$link_qr' class='qr-img' alt='QR Code'>
            </div>
            <p class='note'>Vui lòng quét mã trên để thanh toán nhanh.<br>Nội dung CK: <b>$noi_dung</b></p>
        ";
    }

    // 3. XÓA GIỎ HÀNG (Vì đơn đã lên hệ thống rồi)
    unset($_SESSION['gio_hang']);

    // 4. HIỂN THỊ TRANG THÀNH CÔNG
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Đặt hàng thành công</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Roboto', sans-serif; background: #f4f6f8; text-align: center; padding-top: 30px; }
            .box { background: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
            h1 { color: #27ae60; margin: 10px 0; }
            .icon { font-size: 60px; color: #27ae60; }
            .info { text-align: left; background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #eee; }
            .qr-img { width: 100%; max-width: 300px; border: 2px solid #27ae60; border-radius: 10px; }
            .note { color: #555; font-size: 16px; line-height: 1.5; }
            .btn-home { display: inline-block; background: #C92127; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class="box">
            <div class="icon">✅</div>
            <h1>ĐẶT HÀNG THÀNH CÔNG!</h1>
            <p>Cảm ơn <b><?php echo htmlspecialchars($hoten); ?></b> đã tin tưởng BookStore.</p>
            <p style="color: #666;">Mã đơn hàng: <b>#<?php echo $don_hang_id; ?></b></p>

            <div style="border-top: 2px dashed #ddd; margin-top: 20px; padding-top: 20px;">
                <h3 style="color:#C92127; text-transform:uppercase;"><?php echo $tieu_de; ?></h3>
                <?php echo $html_ket_qua; ?>
            </div>

            <div class="info">
                <p>📍 <b>Giao đến:</b> <?php echo htmlspecialchars($diachi); ?></p>
                <p>💰 <b>Tổng tiền:</b> <?php echo number_format($tongtien, 0, ',', '.'); ?> đ</p>
            </div>

            <a href="index.php" class="btn-home">← Về trang chủ mua tiếp</a>
        </div>
    </body>
    </html>
    <?php
} else {
    header('Location: index.php');
}
?>