<?php
session_start();

if (isset($_GET['id']) && isset($_GET['kieu']) && isset($_SESSION['gio_hang'])) {
    $id = $_GET['id'];
    $kieu = $_GET['kieu']; // 'tang' hoặc 'giam'

    // Kiểm tra sản phẩm có trong giỏ không
    if (array_key_exists($id, $_SESSION['gio_hang'])) {
        
        if ($kieu == 'tang') {
            $_SESSION['gio_hang'][$id]['so_luong']++;
        } elseif ($kieu == 'giam') {
            $_SESSION['gio_hang'][$id]['so_luong']--;
            
            // Nếu giảm xuống 0 thì xóa luôn sản phẩm khỏi giỏ
            if ($_SESSION['gio_hang'][$id]['so_luong'] < 1) {
                unset($_SESSION['gio_hang'][$id]);
            }
        }
    }
}

// Quay lại trang giỏ hàng
header('Location: gio_hang.php');
exit();
?>