<?php
session_start();

// Kiểm tra xem có ID sản phẩm cần xóa được gửi lên không
if (isset($_GET['id']) && isset($_SESSION['gio_hang'])) {
    $id_can_xoa = $_GET['id'];
    
    // Nếu tìm thấy ID đó trong giỏ hàng thì xóa đi
    if (array_key_exists($id_can_xoa, $_SESSION['gio_hang'])) {
        unset($_SESSION['gio_hang'][$id_can_xoa]);
    }
}

// Xử lý xong thì quay ngược lại trang giỏ hàng
header('Location: gio_hang.php');
exit();
?>