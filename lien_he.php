<?php
session_start();

// Logic lấy số lượng giỏ hàng để hiện lên Header
$so_luong_gio_hang = isset($_SESSION['gio_hang']) ? count($_SESSION['gio_hang']) : 0;
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : "Khách";

// Danh mục menu (Để hiển thị đồng bộ)
$danh_muc_chi_tiet = [
    'Tất cả' => 'Tất cả', 'Truyện' => 'Truyện', 'Sách Hay' => 'Sách Hay', 
    'Sách IT' => 'Sách IT', 'Kinh Tế' => 'Kinh Tế', 'Văn Học' => 'Văn Học'
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Liên Hệ - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* --- COPY CSS CHUNG TỪ INDEX.PHP --- */
        * { box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #f0f2f5; margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; width: 100%; }
        a { text-decoration: none; transition: all 0.3s ease; }

        /* HEADER */
        .header-main { background: white; padding: 15px 0; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        .brand { font-size: 32px; font-weight: 900; color: #C92127; letter-spacing: -1px; }
        .search-box { flex: 1; margin: 0 50px; display: flex; border: 2px solid #C92127; border-radius: 50px; overflow: hidden; background: white; max-width: 500px; }
        .search-input { width: 100%; border: none; padding: 12px 20px; outline: none; }
        .search-btn { background: #C92127; color: white; border: none; padding: 0 25px; cursor: pointer; font-weight: bold; }
        .user-actions { display: flex; gap: 25px; align-items: center; }
        .user-actions a { color: #555; font-size: 14px; text-align: center; display: flex; flex-direction: column; align-items: center; }
        .user-actions span { font-size: 20px; margin-bottom: 4px; }

        /* MENU */
        .nav-bar { background: white; border-bottom: 1px solid #eee; margin-bottom: 30px; padding: 15px 0; }
        .nav-flex { display: flex; align-items: center; }
        .cat-label { font-weight: 800; margin-right: 25px; color: #333; text-transform: uppercase; font-size: 14px; }
        .menu-scroll { display: flex; gap: 12px; overflow-x: auto; white-space: nowrap; }
        .menu-scroll a { padding: 8px 20px; background: #f8f9fa; border-radius: 30px; color: #555; border: 1px solid #eee; font-weight: 500; font-size: 14px; }
        .menu-scroll a:hover { background: #C92127; color: white; border-color: #C92127; }

        /* --- CSS RIÊNG CHO TRANG LIÊN HỆ --- */
        .contact-wrapper {
            background: white;
            max-width: 700px;
            margin: 0 auto 50px auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .contact-header { text-align: center; margin-bottom: 30px; }
        .contact-header h2 { color: #C92127; margin: 0 0 10px 0; font-size: 28px; text-transform: uppercase; }
        .contact-header p { color: #666; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #333; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; outline: none; transition: 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: #C92127; box-shadow: 0 0 5px rgba(201, 33, 39, 0.2); }

        .btn-submit { 
            width: 100%; background: #C92127; color: white; padding: 15px; 
            border: none; border-radius: 6px; font-weight: bold; font-size: 16px; 
            cursor: pointer; text-transform: uppercase; transition: 0.3s;
        }
        .btn-submit:hover { background: #a0151a; box-shadow: 0 4px 10px rgba(201, 33, 39, 0.3); }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-top: 20px; text-align: center; border: 1px solid #c3e6cb; }

        /* FOOTER (Đồng bộ) */
        footer { background-color: white; border-top: 1px solid #eee; padding: 50px 0 20px; margin-top: auto; }
        .footer-content-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; padding-bottom: 30px; border-bottom: 1px solid #eee; }
        .footer-col h4 { color: #333; font-size: 16px; margin-bottom: 20px; text-transform: uppercase; font-weight: bold; }
        .footer-col ul { padding: 0; list-style: none; }
        .footer-col li { margin-bottom: 10px; font-size: 14px; color: #666; }
        .footer-col a { color: #666; } .footer-col a:hover { color: #C92127; }
        .copyright { text-align: center; margin-top: 20px; color: #999; font-size: 13px; }
    </style>
</head>
<body>

    <div class="header-main">
        <div class="container header-flex">
            <a href="index.php" class="brand">bookstore</a>
            <form class="search-box" method="GET" action="index.php">
                <input type="text" name="q" class="search-input" placeholder="Tìm kiếm sách...">
                <button class="search-btn">🔍</button>
            </form>
            <div class="user-actions">
                <a href="gio_hang.php"><span>🛒</span>Giỏ hàng (<?php echo $so_luong_gio_hang; ?>)</a>
                <?php if($is_logged_in): ?>
                    <a href="#"><span>👤</span><?php echo htmlspecialchars($username); ?></a>
                <?php else: ?>
                    <a href="login.php"><span>👤</span>Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="nav-bar">
        <div class="container nav-flex">
            <div class="cat-label">☰ DANH MỤC:</div>
            <div class="menu-scroll">
                <a href="index.php">Tất cả</a>
                <?php foreach ($danh_muc_chi_tiet as $key => $ten): ?>
                    <a href="index.php?danhmuc=<?php echo urlencode($key); ?>"><?php echo $ten; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-header">
                <h2>Liên Hệ & Góp Ý</h2>
                <p>Chúng tôi luôn lắng nghe ý kiến của bạn để phục vụ tốt hơn.</p>
            </div>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Họ và tên:</label>
                    <input type="text" name="name" placeholder="Nhập tên của bạn" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Nhập email liên hệ" required>
                </div>
                
                <div class="form-group">
                    <label>Nội dung tin nhắn:</label>
                    <textarea name="message" rows="6" placeholder="Bạn cần hỗ trợ gì hoặc góp ý điều gì?" required></textarea>
                </div>
                
                <button type="submit" name="btn_gui" class="btn-submit">Gửi Tin Nhắn</button>
            </form>
            
            <?php
            if (isset($_POST['btn_gui'])) {
                echo "<div class='alert-success'>✅ Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn và sẽ phản hồi sớm nhất.</div>";
            }
            ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content-grid">
                <div class="footer-col brand-info">
                    <a href="index.php" class="brand" style="font-size:30px;">bookstore</a>
                    <p style="margin-top:10px; font-size:14px; color:#555;">Hệ thống nhà sách online uy tín.</p>
                    <p style="font-size:14px; color:#555;">Hotline: 0909 123 456</p>
                </div>
                <div class="footer-col">
                    <h4>HỖ TRỢ KHÁCH HÀNG</h4>
                    <ul>
                        <li><a href="huong_dan_mua_hang.php">Hướng dẫn mua hàng</a></li>
                        <li><a href="van_chuyen.php">Chính sách vận chuyển</a></li>
                        <li><a href="chinh_sach_doi_tra.php">Chính sách đổi trả</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>VỀ BOOKSTORE</h4>
                    <ul>
                        <li><a href="gioi_thieu.php">Giới thiệu BookStore</a></li>
                        <li><a href="lien_he.php">Liên hệ & Góp ý</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                © 2025 BookStore Project. Bảo lưu mọi quyền.
            </div>
        </div>
    </footer>

</body>
</html>