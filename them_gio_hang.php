<?php
session_start();

// TRẠM GÁC: Chặn không cho khách chưa đăng nhập thêm hàng vào giỏ
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Bạn cần đăng nhập hoặc đăng ký tài khoản để thêm sách vào giỏ hàng nhé!');
            window.location.href = 'login.php';
          </script>";
    exit(); // Chốt chặn, không chạy code xử lý giỏ hàng bên dưới
}

// Kiểm tra xem có dữ liệu gửi lên không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Nhận dữ liệu từ form gửi sang
    $id = $_POST['id'] ?? null;
    $ten = $_POST['tensach'] ?? 'Sản phẩm không tên';
    $gia = isset($_POST['gia']) ? (float)$_POST['gia'] : 0;
    $hinh = $_POST['hinh'] ?? '';
    
    // 2. NHẬN SỐ LƯỢNG TỪ NGƯỜI DÙNG (Quan trọng)
    // Nếu có nhập số lượng thì lấy số đó, không thì mặc định là 1
    $so_luong_mua = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 1;
    if ($so_luong_mua < 1) $so_luong_mua = 1;

    // 3. Kiểm tra dữ liệu hợp lệ
    if ($id && $gia > 0) {
        
        // Tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['gio_hang'])) {
            $_SESSION['gio_hang'] = [];
        }

        // Logic thêm vào giỏ (Key là ID sản phẩm)
        if (array_key_exists($id, $_SESSION['gio_hang'])) {
            // Nếu sản phẩm ĐÃ CÓ -> Cộng dồn số lượng khách chọn
            $_SESSION['gio_hang'][$id]['so_luong'] += $so_luong_mua;
        } else {
            // Nếu sản phẩm CHƯA CÓ -> Thêm mới vào mảng
            $_SESSION['gio_hang'][$id] = [
                'id' => $id,
                'ten_sach' => $ten,
                'gia' => $gia,
                'hinh' => $hinh,
                'so_luong' => $so_luong_mua
            ];
        }
    }

    // 4. ĐIỀU HƯỚNG (Quan trọng)
    
    // Nếu khách bấm nút "Mua ngay" (name='buy_now') -> Đi thẳng tới Giỏ hàng
    if (isset($_POST['buy_now'])) {
        header('Location: gio_hang.php');
        exit();
    } 
    
    // Nếu khách bấm "Thêm vào giỏ" -> Quay lại trang vừa đứng (để mua tiếp)
    else {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header('Location: index.php');
        }
        exit();
    }
}

// Nếu vào trực tiếp file này mà không bấm nút -> Về trang chủ
header('Location: index.php');
exit();
?>