<?php
session_start();
include 'config.php'; 

// 1. LOGIC CƠ BẢN
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : "Khách";
$so_luong_gio_hang = isset($_SESSION['gio_hang']) ? count($_SESSION['gio_hang']) : 0;

$danh_muc_chi_tiet = [
    'Tất cả'   => ['Tên hiển thị' => 'Tất cả', 'Mô tả' => 'Khám phá kho tàng tri thức vô tận tại BookStore.'],
    'Truyện'   => ['Tên hiển thị' => 'Truyện', 'Mô tả' => 'Những câu chuyện đầy cảm xúc, tiểu thuyết và truyện ngắn.'],
    'Sách Hay' => ['Tên hiển thị' => 'Sách Hay', 'Mô tả' => 'Top những cuốn sách bán chạy nhất mọi thời đại.'],
    'Sách IT'  => ['Tên hiển thị' => 'Sách IT', 'Mô tả' => 'Cập nhật công nghệ mới nhất cho dân lập trình.'],
    'Kinh Tế'  => ['Tên hiển thị' => 'Kinh Tế', 'Mô tả' => 'Bí quyết đầu tư, tài chính và quản trị kinh doanh.'],
    'Văn Học'  => ['Tên hiển thị' => 'Văn Học', 'Mô tả' => 'Tuyển tập các tác phẩm văn học kinh điển.'],
];

// 2. XỬ LÝ LỌC & TÌM KIẾM
$current_danhmuc = isset($_GET['danhmuc']) ? $_GET['danhmuc'] : 'Tất cả';
$search_keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT * FROM sach WHERE 1=1";
if ($current_danhmuc != 'Tất cả') {
    $sql .= " AND danhmuc = '$current_danhmuc'";
    $tieu_de_hien_thi = $current_danhmuc;
    $mo_ta_chuyen_muc = isset($danh_muc_chi_tiet[$current_danhmuc]) ? $danh_muc_chi_tiet[$current_danhmuc]['Mô tả'] : '';
} else {
    $tieu_de_hien_thi = "Tất cả sách mới";
    $mo_ta_chuyen_muc = "Khám phá kho tàng tri thức vô tận tại BookStore.";
}

if ($search_keyword != '') {
    $sql .= " AND ten_sach LIKE '%$search_keyword%'";
    $tieu_de_hien_thi = "Tìm kiếm: '" . htmlspecialchars($search_keyword) . "'";
    $mo_ta_chuyen_muc = "Các sách phù hợp với từ khóa bạn nhập.";
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>BookStore - <?php echo $tieu_de_hien_thi; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        /* CSS GIAO DIỆN CHUNG */
        * { box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: #f0f2f5; margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; width: 100%; }
        a { text-decoration: none; }

        /* HEADER & NAV */
        .header-main { background: white; padding: 15px 0; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        .brand { font-size: 32px; font-weight: 900; color: #C92127; }
        .search-box { flex: 1; margin: 0 50px; display: flex; border: 2px solid #C92127; border-radius: 50px; overflow: hidden; max-width: 500px; }
        .search-input { width: 100%; border: none; padding: 10px 20px; outline: none; }
        .search-btn { background: #C92127; color: white; border: none; padding: 0 20px; cursor: pointer; }
        
        .user-actions { display: flex; gap: 20px; font-size: 14px; align-items: center; }
        .user-link { color: #0d6efd; font-weight: bold; padding: 6px 12px; border-radius: 20px; background: #eef4ff; transition: 0.2s; }
        .user-link:hover { background: #0d6efd; color: white; }
        .nav-bar { background: white; border-bottom: 1px solid #eee; padding: 10px 0; margin-bottom: 20px; }
        .menu-scroll { display: flex; gap: 10px; overflow-x: auto; }
        .menu-scroll a { padding: 8px 15px; background: #f8f9fa; border-radius: 20px; color: #555; font-size: 14px; border: 1px solid #ddd; }
        .menu-scroll a.active { background: #C92127; color: white; border-color: #C92127; }

        /* CSS BANNER SLIDER */
        .banner-container { border-radius: 12px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: white; }
        .swiper-slide img { width: 100%; height: 350px; object-fit: contain; background: #f9f9f9; }
        .slide-content { position: absolute; bottom: 0; width: 100%; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 20px; text-align: left; }

        /* GRID SÁCH */
        .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px; }
        .book-card { background: white; border-radius: 8px; overflow: hidden; border: 1px solid #eee; transition: 0.3s; display: flex; flex-direction: column; }
        .book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .img-wrap { height: 200px; padding: 10px; display: flex; align-items: center; justify-content: center; }
        .book-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .card-body { padding: 15px; flex-grow: 1; }
        .book-title { font-weight: bold; font-size: 14px; height: 40px; overflow: hidden; margin-bottom: 10px; }
        .book-price { color: #C92127; font-weight: 800; }
        .btn-buy { width: 100%; padding: 8px; border: 1px solid #C92127; background: white; color: #C92127; font-weight: bold; cursor: pointer; border-radius: 5px; }
        .btn-buy:hover { background: #C92127; color: white; }

        .section-header { border-left: 5px solid #C92127; padding-left: 15px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="header-main">
        <div class="container header-flex">
            <a href="index.php" class="brand">bookstore</a>
            <form class="search-box" method="GET" action="index.php">
                <input type="text" name="q" class="search-input" placeholder="Tìm sách..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                <button class="search-btn">🔍</button>
            </form>
            <div class="user-actions">
                <a href="gio_hang.php">🛒 (<?php echo $so_luong_gio_hang; ?>)</a>
                <?php if($is_logged_in): ?>
                    <?php if(strpos(strtolower($username), 'admin') !== false): ?>
                        <a href="admin.php" title="Trang Quản Trị">⚙️</a>
                    <?php endif; ?>
                    
                    <a href="khach_hang.php" class="user-link" title="Xem đơn hàng & Thẻ VIP NFT">👤 <?php echo htmlspecialchars($username); ?></a>
                    <a href="logout.php" style="color:red">Thoát</a>
                <?php else: ?>
                    <a href="login.php">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="nav-bar">
        <div class="container">
            <div class="menu-scroll">
                <a href="index.php" class="<?php echo ($current_danhmuc === 'Tất cả' && $search_keyword == '') ? 'active' : ''; ?>">Tất cả</a>
                <?php foreach ($danh_muc_chi_tiet as $key => $dm): ?>
                    <?php if($key != 'Tất cả'): ?>
                    <a href="index.php?danhmuc=<?php echo urlencode($key); ?>" 
                       class="<?php echo ($current_danhmuc === $key) ? 'active' : ''; ?>">
                       <?php echo htmlspecialchars($dm['Tên hiển thị']); ?>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($current_danhmuc == 'Tất cả' && $search_keyword == ''): ?>
        <div class="banner-container">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php
                    $sql_sl = "SELECT * FROM sach ORDER BY id DESC LIMIT 5";
                    $res_sl = mysqli_query($conn, $sql_sl);
                    while($row_sl = mysqli_fetch_assoc($res_sl)) {
                        echo '<div class="swiper-slide">';
                        echo '<img src="images/'.$row_sl['hinh_anh'].'">';
                        echo '<div class="slide-content"><h3>HOT: '.$row_sl['ten_sach'].'</h3></div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="section-header">
            <h3>📖 <?php echo $tieu_de_hien_thi; ?></h3>
            <p><?php echo $mo_ta_chuyen_muc; ?></p>
        </div>

        <div class="book-grid">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="book-card">
                <a href="chi_tiet_sach.php?id=<?php echo $row['id']; ?>" style="color:inherit">
                    <div class="img-wrap"><img src="images/<?php echo $row['hinh_anh']; ?>" class="book-img"></div>
                    <div class="card-body">
                        <div class="book-title"><?php echo $row['ten_sach']; ?></div>
                        <div class="book-price"><?php echo number_format($row['gia'], 0, ',', '.'); ?> đ</div>
                    </div>
                </a>
                <form action="them_gio_hang.php" method="POST" style="padding:10px">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn-buy">Thêm vào giỏ</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php if(file_exists('footer.php')) include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: { delay: 3000 },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });
    </script>
</body>
</html>