<?php
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, 'UTF8');
$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $thong_bao = "❌ Tên này đã có người dùng!";
    } else {
        $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', 'user')";
        if (mysqli_query($conn, $sql)) {
            $thong_bao = "✅ Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>";
        } else {
            $thong_bao = "Lỗi hệ thống!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Tài Khoản</title>
    <style>
        /* Dùng chung style với Login cho đồng bộ */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; }
        .header-bg { position: absolute; top: 0; width: 100%; height: 200px; background: linear-gradient(to right, #2c3e50, #4ca1af); z-index: -1; }
        .form-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        h2 { color: #2c3e50; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; outline: none; }
        input:focus { border-color: #4ca1af; }
        button { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        button:hover { background: #219150; }
        .message { margin-bottom: 15px; font-weight: bold; color: green; }
        a { text-decoration: none; color: #4ca1af; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header-bg"></div>

    <div class="form-box">
        <h2>📝 ĐĂNG KÝ MỚI</h2>
        <div class="message"><?php echo $thong_bao; ?></div>

        <form method="post" action="">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="email" name="email" placeholder="Email (nếu có)">
            <button type="submit">Đăng Ký Ngay</button>
        </form>

        <p style="margin-top: 20px; color: #666;">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </p>
        <p><a href="index.php">← Về trang chủ</a></p>
    </div>
</body>
</html>