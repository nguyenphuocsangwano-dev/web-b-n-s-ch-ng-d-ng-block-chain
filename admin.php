<?php
session_start();

// 1. KẾT NỐI DATABASE
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, 'UTF8');

// --- KIỂM TRA ĐĂNG NHẬP ---
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// --- 2. XỬ LÝ THÊM SÁCH ---
$thong_bao = "";
if (isset($_POST['them_sach'])) {
    $ten = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $gia = $_POST['gia'];
    $so_luong = $_POST['so_luong'];
    $danhmuc = $_POST['danhmuc'];
    $mota = $_POST['mota'];
    $ngay_nhap = $_POST['ngay_nhap'];
    $ngay_ban = $_POST['ngay_ban'];

    $hinh = $_FILES['hinh_anh']['name'];
    $hinh_tmp = $_FILES['hinh_anh']['tmp_name'];
    
    if ($hinh != "") {
        move_uploaded_file($hinh_tmp, "images/" . $hinh);
    } else {
        $hinh = "no-image.png"; 
    }

    $sql_them = "INSERT INTO sach (ten_sach, tac_gia, gia, so_luong, hinh_anh, danhmuc, mota, ngay_nhap, ngay_ban) 
                 VALUES ('$ten', '$tac_gia', '$gia', '$so_luong', '$hinh', '$danhmuc', '$mota', '$ngay_nhap', '$ngay_ban')";
    
    if (mysqli_query($conn, $sql_them)) {
        $thong_bao = "✅ Thêm sách thành công!";
    } else {
        $thong_bao = "❌ Lỗi: " . mysqli_error($conn);
    }
}

// --- 3. XỬ LÝ XÓA SÁCH ---
if (isset($_GET['xoa'])) {
    $id_xoa = $_GET['xoa'];
    mysqli_query($conn, "DELETE FROM sach WHERE id = $id_xoa");
    header("Location: admin.php"); 
    exit();
}

// ==========================================
// THÊM MỚI: XỬ LÝ QUẢN LÝ CHATBOT FAQ
// ==========================================
if (isset($_POST['btn_add_faq'])) {
    $cau_hoi = mysqli_real_escape_string($conn, $_POST['cau_hoi']);
    $cau_tra_loi = mysqli_real_escape_string($conn, $_POST['cau_tra_loi']);
    mysqli_query($conn, "INSERT INTO chat_faq (cau_hoi, cau_tra_loi, trang_thai) VALUES ('$cau_hoi', '$cau_tra_loi', 1)");
    header("Location: admin.php");
    exit();
}

if (isset($_GET['del_faq'])) {
    $id_faq = (int)$_GET['del_faq'];
    mysqli_query($conn, "DELETE FROM chat_faq WHERE id = $id_faq");
    header("Location: admin.php");
    exit();
}

if (isset($_GET['toggle_faq'])) {
    $id_faq = (int)$_GET['toggle_faq'];
    $new_status = ($_GET['status'] == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE chat_faq SET trang_thai = $new_status WHERE id = $id_faq");
    header("Location: admin.php");
    exit();
}

// ==========================================
// THÊM MỚI: XỬ LÝ QUẢN LÝ TÀI KHOẢN
// ==========================================
if (isset($_GET['del_user'])) {
    $id_user = (int)$_GET['del_user'];
    if ($id_user != 1) { // Bảo vệ không cho xóa admin id=1
        // LƯU Ý: Thay chữ 'users' thành tên bảng tài khoản của ní
        mysqli_query($conn, "DELETE FROM users WHERE id = $id_user");
        header("Location: admin.php");
        exit();
    } else {
        echo "<script>alert('Lỗi: Không thể tự xóa tài khoản Admin chính!');</script>";
    }
}

// --- 4. ĐĂNG XUẤT ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị Cửa Hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f4f6f9; padding: 20px; }
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* Header */
        .header { display: flex; justify-content: space-between; align-items: center; background: #343a40; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; }
        .user-info { font-weight: bold; }
        .btn-logout { background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 10px;}
        .btn-home { background: #17a2b8; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }

        /* Menu Admin Mới */
        .admin-menu { background: #495057; padding: 10px 20px; border-radius: 0 0 8px 8px; margin-bottom: 20px; display: flex; gap: 15px; }
        .admin-menu a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-weight: 500; transition: background 0.3s;}
        .admin-menu a:hover, .admin-menu a.active { background: #C92127; }

        /* Form Nhập liệu */
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h3 { margin-top: 0; color: #C92127; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; color: #555; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        
        .btn-them { background: #28a745; color: white; border: none; padding: 12px 30px; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; margin-top: 10px; font-size: 16px; }
        .btn-them:hover { background: #218838; }

        /* Bảng Danh sách */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th { background-color: #333; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; font-size: 14px; }
        .thumb-img { width: 50px; height: 70px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; }
        .price { color: #C92127; font-weight: bold; }
        .btn-delete { color: white; background: #dc3545; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; display: inline-block; text-align: center;}
        
        .alert { color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px; text-align: center; font-weight: bold;}
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h1 style="margin: 0; font-size: 24px;">⚙️ ADMIN PANEL</h1>
        </div>
        <div>
            <span class="user-info">Xin chào, <?php echo $_SESSION['username']; ?></span>
            <a href="index.php" class="btn-home" target="_blank">🌐 Xem Web</a>
            <a href="admin.php?logout=true" class="btn-logout">Đăng xuất</a>
        </div>
    </div>

    <div class="admin-menu">
        <a href="admin.php" class="active">📦 Quản lý Sách & Kho</a>
        <a href="admin_orders.php">🛒 Quản lý Đơn Hàng</a>
    </div>

    <div class="card">
        <h3>➕ NHẬP SÁCH MỚI</h3>
        <?php if($thong_bao != "") echo "<div class='alert'>$thong_bao</div>"; ?>
        
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-grid">
                <div>
                    <div class="form-group">
                        <label>Tên sách:</label>
                        <input type="text" name="ten_sach" required>
                    </div>
                    <div class="form-group">
                        <label>Tác giả:</label>
                        <input type="text" name="tac_gia" required>
                    </div>
                    <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label>Giá tiền:</label>
                            <input type="number" name="gia" required>
                        </div>
                        <div class="form-group">
                            <label>Số lượng:</label>
                            <input type="number" name="so_luong" value="10">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Danh mục:</label>
                        <select name="danhmuc">
                            <option value="Sách IT">Sách IT</option>
                            <option value="Truyện">Truyện</option>
                            <option value="Sách Hay">Sách Hay</option>
                            <option value="Kinh Tế">Kinh Tế</option>
                            <option value="Văn Học">Văn Học</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label>Ảnh bìa sách:</label>
                        <input type="file" name="hinh_anh" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày nhập sách:</label>
                        <input type="date" name="ngay_nhap" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Ngày mở bán (Dự kiến):</label>
                        <input type="date" name="ngay_ban" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Mô tả ngắn:</label>
                        <textarea name="mota" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" name="them_sach" class="btn-them">LƯU VÀO KHO</button>
        </form>
    </div>

    <div class="card">
        <h3>📚 KHO SÁCH HIỆN TẠI</h3>
        <table>
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Hình</th>
                    <th width="25%">Tên Sách</th>
                    <th width="15%">Tác Giả</th>
                    <th width="10%">Giá</th>
                    <th width="10%">Kho</th>
                    <th width="15%">Ngày Nhập</th>
                    <th width="10%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM sach ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) { 
                ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><img src="images/<?php echo $row['hinh_anh']; ?>" class="thumb-img"></td>
                        <td>
                            <b><?php echo $row['ten_sach']; ?></b><br>
                            <small style="color:#777"><?php echo $row['danhmuc']; ?></small>
                        </td>
                        <td><?php echo $row['tac_gia']; ?></td>
                        <td class="price"><?php echo number_format($row['gia']); ?> đ</td>
                        <td><?php echo $row['so_luong']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($row['ngay_nhap'])); ?></td>
                        <td>
                            <a href="admin.php?xoa=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa cuốn này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center; padding: 20px;'>Kho chưa có sách nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="color: #6f42c1;">🤖 QUẢN LÝ CÂU HỎI BOT CHAT</h3>
        
        <form method="POST" action="admin.php" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 5px;">
            <div style="margin-bottom: 10px;">
                <label>Câu hỏi của khách:</label>
                <input type="text" name="cau_hoi" required placeholder="VD: Phí giao hàng nội thành là bao nhiêu?">
            </div>
            <div style="margin-bottom: 10px;">
                <label>Bot trả lời:</label>
                <textarea name="cau_tra_loi" required rows="2" placeholder="VD: Dạ phí ship nội thành là 20.000đ ạ."></textarea>
            </div>
            <button type="submit" name="btn_add_faq" style="background: #6f42c1; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer;">+ Thêm vào Bot</button>
        </form>

        <table>
            <thead>
                <tr style="background: #6f42c1;">
                    <th width="5%">ID</th>
                    <th width="35%">Câu hỏi</th>
                    <th width="40%">Câu trả lời</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($conn)) {
                    // Dùng @ để ẩn lỗi nếu ní lỡ chưa tạo bảng
                    $faq_list = @mysqli_query($conn, "SELECT * FROM chat_faq ORDER BY id DESC");
                    if($faq_list){
                        while ($row = mysqli_fetch_assoc($faq_list)) {
                            $status_text = $row['trang_thai'] == 1 ? '<span style="color: #28a745; font-weight: bold;">Hiện</span>' : '<span style="color: #dc3545; font-weight: bold;">Ẩn</span>';
                            $toggle_btn = $row['trang_thai'] == 1 ? 'Ẩn đi' : 'Hiện lên';
                            $toggle_color = $row['trang_thai'] == 1 ? '#ffc107' : '#28a745';
                            
                            echo "<tr>
                                <td>#{$row['id']}</td>
                                <td><b>{$row['cau_hoi']}</b></td>
                                <td style='color: #666;'>{$row['cau_tra_loi']}</td>
                                <td>{$status_text}</td>
                                <td>
                                    <a href='admin.php?toggle_faq={$row['id']}&status={$row['trang_thai']}' style='background: {$toggle_color}; color: #333; padding: 5px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; display: block; text-align: center; margin-bottom: 5px;'>{$toggle_btn}</a>
                                    <a href='admin.php?del_faq={$row['id']}' onclick='return confirm(\"Xóa câu hỏi này?\")' class='btn-delete' style='display: block; width: 100%; box-sizing: border-box;'>Xóa</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>Chưa có bảng chat_faq. Ní nhớ chạy SQL tạo bảng nhé!</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="color: #007bff;">👥 QUẢN LÝ TÀI KHOẢN</h3>
        <table>
            <thead>
                <tr style="background: #007bff;">
                    <th width="10%">ID</th>
                    <th width="40%">Tên đăng nhập</th>
                    <th width="30%">Mật khẩu</th>
                    <th width="20%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 🔴 THAY TÊN BẢNG 'users' BẰNG TÊN BẢNG TÀI KHOẢN CỦA NÍ Ở ĐÂY NHÉ:
                $table_user = 'users'; 
                
                if(isset($conn)) {
                    $user_list = @mysqli_query($conn, "SELECT * FROM $table_user ORDER BY id ASC");
                    if($user_list) {
                        while ($row = mysqli_fetch_assoc($user_list)) {
                            echo "<tr>
                                <td>#{$row['id']}</td>
                                <td><b>{$row['username']}</b></td>
                                <td style='color: #999;'>********</td>
                                <td>";
                            if ($row['id'] != 1) { // Không cho xóa Admin
                                echo "<a href='admin.php?del_user={$row['id']}' onclick='return confirm(\"Xóa tài khoản này?\")' class='btn-delete'>Xóa User</a>";
                            } else {
                                echo "<span style='color: #28a745; font-weight: bold;'>ADMIN</span>";
                            }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center; color: red;'>⚠️ Lỗi: Không tìm thấy bảng '$table_user' trong Database. Kéo lên dòng 331 trong code đổi tên bảng lại nhé!</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>