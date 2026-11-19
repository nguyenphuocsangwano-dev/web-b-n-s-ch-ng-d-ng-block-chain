<?php
// Tắt hiển thị lỗi HTML để đảm bảo luôn trả về JSON chuẩn
error_reporting(0);
ini_set('display_errors', 0);
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "bookstore");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Lỗi kết nối CSDL: " . $conn->connect_error]);
    exit;
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data || empty($data['vi_khach_hang']) || empty($data['tx_hash'])) {
    echo json_encode(["status" => "error", "message" => "Thiếu thông tin ví hoặc mã giao dịch!"]);
    exit;
}

$vi = $conn->real_escape_string($data['vi_khach_hang']);
$ho_ten = $conn->real_escape_string($data['ho_ten'] ?? 'Khách hàng Web3');
$sdt = $conn->real_escape_string($data['sdt'] ?? '');
$dia_chi = $conn->real_escape_string($data['dia_chi'] ?? '');
$tong_vnd = floatval($data['tong_tien_vnd'] ?? 0);
$tong_eth = floatval($data['tong_tien_eth'] ?? 0);
$tx_hash = $conn->real_escape_string($data['tx_hash']);

// Làm mới bảng don_hang_crypto cho khớp đúng các cột dữ liệu
$conn->query("DROP TABLE IF EXISTS don_hang_crypto");
$conn->query("CREATE TABLE don_hang_crypto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vi_khach_hang VARCHAR(100) NOT NULL,
    ho_ten VARCHAR(150),
    sdt VARCHAR(20),
    dia_chi TEXT,
    tong_tien_vnd DECIMAL(15,2),
    tong_tien_eth DECIMAL(18,8),
    tx_hash VARCHAR(100),
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$sql_insert = "INSERT INTO don_hang_crypto (vi_khach_hang, ho_ten, sdt, dia_chi, tong_tien_vnd, tong_tien_eth, tx_hash) 
               VALUES ('$vi', '$ho_ten', '$sdt', '$dia_chi', $tong_vnd, $tong_eth, '$tx_hash')";

if ($conn->query($sql_insert)) {
    // Làm mới bảng vi_thanh_vien_nft để tích điểm VIP
    $conn->query("DROP TABLE IF EXISTS vi_thanh_vien_nft");
    $conn->query("CREATE TABLE vi_thanh_vien_nft (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dia_chi_vi VARCHAR(100) UNIQUE,
        diem_tich_luy INT DEFAULT 0,
        hang_the VARCHAR(50) DEFAULT 'VIP Bạc (Giảm 5%)'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $diem_cong = intval($tong_vnd / 10000);
    $conn->query("INSERT INTO vi_thanh_vien_nft (dia_chi_vi, diem_tich_luy, hang_the) 
                  VALUES ('$vi', $diem_cong, 'VIP Bạc (Giảm 5%)')");

    echo json_encode([
        "status" => "success",
        "message" => "Lưu đơn hàng Blockchain và cộng điểm VIP NFT thành công!",
        "tx_hash" => $tx_hash
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Lỗi SQL: " . $conn->error
    ]);
}
$conn->close();
?>