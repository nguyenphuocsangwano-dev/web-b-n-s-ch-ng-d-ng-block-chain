<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : "Khách";
$so_luong_gio_hang = isset($_SESSION['gio_hang']) ? count($_SESSION['gio_hang']) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giới thiệu - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS DÙNG CHUNG (HEADER/FOOTER) */
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Roboto', sans-serif; background: #f4f6f8; color: #333; display: flex; flex-direction: column; }
        a { text-decoration: none; transition: 0.2s; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        
        /* HEADER */
        .header-main { background: white; padding: 15px 0; border-bottom: 1px solid #eee; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        .brand { font-size: 28px; font-weight: 900; color: #C92127; }
        .user-actions { display: flex; gap: 20px; align-items: center; }
        .user-actions a { color: #555; font-size: 13px; text-align: center; }
        
        /* NỘI DUNG TRANG */
        .page-content { flex: 1; padding: 40px 0; background: white; margin-top: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h1 { color: #C92127; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        p { line-height: 1.8; color: #555; margin-bottom: 15px; text-align: justify; }
        .highlight { color: #C92127; font-weight: bold; }

        /* FOOTER */
        footer { background-color: white; border-top: 4px solid #C92127; padding: 40px 0 20px; margin-top: auto; }
        .footer-content { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px; }
        .footer-col h4 { color: #C92127; margin-bottom: 20px; }
        .footer-col li { list-style: none; margin-bottom: 10px; font-size: 14px; color: #666; }
        .footer-col a { color: #666; } .footer-col a:hover { color: #C92127; }
        .copyright { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 13px; color: #999; }
    </style>
</head>
<body>

    <div class="header-main">
        <div class="container header-flex">
            <a href="index.php" class="brand">bookstore</a>
            <div class="user-actions">
                <a href="index.php">🏠 Trang chủ</a>
                <a href="gio_hang.php">🛒 Giỏ hàng (<?php echo $so_luong_gio_hang; ?>)</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-content" style="padding: 40px;">
            <h1>Về BookStore</h1>
            <p>Chào mừng bạn đến với <span class="highlight">BookStore</span> – Ngôi nhà tri thức dành cho những người yêu sách!</p>
            
            <p>Được thành lập với niềm đam mê lan tỏa văn hóa đọc, BookStore không chỉ là nơi bán sách, mà còn là cầu nối mang những tác phẩm giá trị đến tay bạn đọc trên khắp cả nước. Chúng tôi tự hào cung cấp hàng ngàn đầu sách đa dạng từ Văn học, Kinh tế, Kỹ năng sống cho đến Sách chuyên ngành CNTT.</p>

            <h3>Tầm nhìn & Sứ mệnh</h3>
            <p>Sứ mệnh của chúng tôi là <span class="highlight">"Mang tri thức đến mọi nhà"</span>. Chúng tôi cam kết:</p>
            <ul>
                <li>Cung cấp sách bản quyền 100%, chất lượng in ấn tốt nhất.</li>
                <li>Dịch vụ chăm sóc khách hàng tận tâm, hỗ trợ đổi trả nhanh chóng.</li>
                <li>Giá cả hợp lý, thường xuyên có các chương trình khuyến mãi tri ân.</li>
            </ul>

            <h3>Đội ngũ của chúng tôi</h3>
            <p>Đội ngũ BookStore là những người trẻ, năng động và am hiểu về sách. Chúng tôi luôn sẵn sàng lắng nghe và tư vấn để giúp bạn tìm được cuốn sách ưng ý nhất.</p>
            
            <p>Cảm ơn bạn đã tin tưởng và lựa chọn BookStore. Chúc bạn có những phút giây mua sắm vui vẻ!</p>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <h4 class="brand" style="font-size:20px;">bookstore</h4>
                    <p style="font-size:14px; color:#666;">Hệ thống nhà sách online uy tín.</p>
                </div>
                <div class="footer-col">
                    <h4>VỀ CHÚNG TÔI</h4>
                    <li><a href="gioi_thieu.php">Giới thiệu</a></li>
                    <li><a href="lien_he.php">Liên hệ</a></li>
                </div>
            </div>
            <div class="copyright">© 2024 BookStore Project.</div>
        </div>
    </footer>

</body>
</html>