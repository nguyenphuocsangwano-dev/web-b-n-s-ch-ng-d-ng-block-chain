<div class="newsletter-bar">
    <div class="container newsletter-flex">
        <div class="newsletter-info">
            <span style="font-size:24px;">📧</span> 
            <span class="text-uppercase fw-bold">Đăng ký nhận bản tin & ưu đãi</span>
        </div>
        <form class="newsletter-form" action="#" method="POST">
            <input type="email" placeholder="Nhập email của bạn...">
            <button type="submit">Đăng ký</button>
        </form>
    </div>
</div>

<footer>
    <div class="container">
        <div class="footer-content-grid">
            
            <div class="footer-col brand-info">
                <a href="index.php" class="brand" style="font-size:30px;">bookstore</a>
                <p>Hệ thống nhà sách online uy tín hàng đầu Việt Nam.</p>
                <p><strong>Địa chỉ:</strong> Ninh Kiều, Cần Thơ</p>
                <p><strong>Hotline:</strong> 036 7306 447</p>
            </div>
            
            <div class="footer-col">
                <h4>HỖ TRỢ KHÁCH HÀNG</h4>
                <ul>
                    <li><a href="huong_dan_mua_hang.php">Hướng dẫn mua hàng</a></li>
                    <li><a href="van_chuyen.php">Chính sách vận chuyển</a></li>
                    <li><a href="#">Phương thức thanh toán</a></li>
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

<style>
    /* =========================================
       CSS CHO FOOTER & NEWSLETTER 
       ========================================= */
    .newsletter-bar { background-color: #C92127; padding: 30px 0; margin-top: 50px; font-family: 'Roboto', sans-serif;}
    .newsletter-flex { display: flex; justify-content: space-between; align-items: center; color: white; flex-wrap: wrap; gap: 20px; }
    .newsletter-info .fw-bold { font-weight: 700; font-size: 18px; margin-left: 10px;}
    .newsletter-form { display: flex; width: 50%; max-width: 500px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .newsletter-form input { flex-grow: 1; padding: 12px; border: none; border-radius: 6px 0 0 6px; outline: none; }
    .newsletter-form button { background-color: #333; color: white; border: none; padding: 12px 25px; font-weight: bold; cursor: pointer; border-radius: 0 6px 6px 0; transition: 0.3s; }
    .newsletter-form button:hover { background-color: #000; }
    
    footer { background-color: white; border-top: 1px solid #eee; padding: 60px 0 30px; font-family: 'Roboto', sans-serif;}
    
    /* ĐÃ CHỈNH LẠI THÀNH 3 CỘT CHO CÂN ĐỐI NHA NÍ */
    .footer-content-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; padding-bottom: 40px; border-bottom: 1px solid #eee; }
    
    .footer-col h4 { color: #333; font-size: 16px; margin-bottom: 25px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
    .footer-col p { color: #666; font-size: 14px; line-height: 1.6; }
    .footer-col ul { padding: 0; list-style: none; margin: 0;}
    .footer-col li { margin-bottom: 12px; font-size: 14px; color: #666; }
    .footer-col a { color: #666; transition: 0.3s; position: relative; text-decoration: none;}
    .footer-col a:hover { color: #C92127; padding-left: 8px; }
    
    .brand-info .brand { font-size: 32px !important; font-weight: 900; color: #C92127; letter-spacing: -1px; text-transform: lowercase; }
    .copyright { text-align: center; margin-top: 30px; color: #999; font-size: 13px; }

    @media (max-width: 768px) {
        .footer-content-grid { grid-template-columns: 1fr; text-align: center; }
        .newsletter-flex { flex-direction: column; text-align: center; } 
        .newsletter-form { width: 100%; }
        .footer-col a:hover { padding-left: 0; }
    }
</style>

<?php include 'chatbot.php'; ?>