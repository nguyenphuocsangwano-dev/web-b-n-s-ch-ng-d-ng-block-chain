<?php
// 1. Kết nối
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, 'UTF8');

// 2. Nhận dữ liệu từ trang Admin gửi sang
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['ten_sach'];
    $gia = $_POST['gia'];
    
    // Mặc định mấy cái này cho nhanh (sau này nâng cấp sau)
    $tac_gia = "Đang cập nhật"; 
    $the_loai = "Sách mới";
    $so_luong = 10;

    // 3. Viết lệnh SQL thêm vào kho
    $sql = "INSERT INTO Sach (ten_sach, gia, tac_gia, the_loai, so_luong) 
            VALUES ('$ten', '$gia', '$tac_gia', '$the_loai', $so_luong)";

    // 4. Chạy lệnh và quay về trang Admin
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php"); // Quay lại trang quản trị
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>