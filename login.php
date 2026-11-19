<?php
session_start(); // Khởi động phiên làm việc để nhớ đăng nhập
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, 'UTF8');

$thong_bao = "";

// Kiểm tra khi người dùng bấm nút Đăng Nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tìm trong kho dữ liệu xem có ai tên đó, mật khẩu đó không
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Đăng nhập thành công!
        $row = mysqli_fetch_assoc($result);
        
        // Lưu thông tin vào máy (Session) để web nhớ là đã đăng nhập
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role']; // Lưu quyền (admin hay user)

        // Điều hướng: Nếu là Admin thì vào trang quản trị, khách thì về trang chủ
        if ($row['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $thong_bao = "❌ Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-bottom: 10px; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>🔐 ĐĂNG NHẬP</h2>
        
        <?php if($thong_bao != "") { ?>
            <p class="error"><?php echo $thong_bao; ?></p>
        <?php } ?>

        <form method="post" action="">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng Nhập</button>
        </form>
        
        <p style="margin-top: 20px;">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </p>
        <p><a href="index.php">← Về trang chủ</a></p>
    </div>

</body>
</html>