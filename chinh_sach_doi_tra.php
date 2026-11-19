<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chính Sách Đổi Trả - BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS trang trí cho phần Chính sách */
        body { background-color: #f4f6f9; }
        .policy-wrapper { padding: 40px 0; min-height: 60vh; }
        .policy-container {
            max-width: 900px; margin: 0 auto; padding: 40px;
            font-family: 'Roboto', sans-serif; background: #fff;
            border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .policy-title {
            color: #C92127; text-align: center; font-weight: 900;
            font-size: 28px; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 1px;
        }
        .policy-section { margin-bottom: 30px; }
        .policy-section h4 {
            color: #2c3e50; font-size: 18px; font-weight: bold;
            border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 15px; display: flex; align-items: center;
        }
        .policy-section h4::before { content: "📚"; margin-right: 10px; font-size: 20px; }
        .policy-section ul { list-style-type: none; padding-left: 0; }
        .policy-section li { color: #555; line-height: 1.8; margin-bottom: 10px; position: relative; padding-left: 25px; }
        .policy-section li::before { content: "✓"; color: #27ae60; position: absolute; left: 0; font-weight: bold; }
        .highlight-step {
            background-color: #fff9f9; border-left: 4px solid #C92127;
            padding: 10px 15px; margin-bottom: 10px; border-radius: 0 5px 5px 0;
        }
    </style>
</head>
<body>

    <div class="policy-wrapper">
        <div class="container">
            <div class="policy-container">
                <h1 class="policy-title">Chính Sách Đổi Trả Hàng</h1>

                <div class="policy-section">
                    <h4>Điều kiện đổi trả</h4>
                    <ul>
                        <li>Thời gian hỗ trợ đổi trả: Trong vòng <strong>07 ngày</strong> kể từ ngày quý khách nhận được hàng.</li>
                        <li>Sách phải còn nguyên vẹn, không bị nhăn, rách, bẩn hoặc có dấu hiệu đã qua sử dụng.</li>
                        <li>Sách còn đầy đủ phụ kiện đi kèm (nếu có) như bookmark, CD, poster...</li>
                    </ul>
                </div>

                <div class="policy-section">
                    <h4>Trường hợp được chấp nhận đổi/trả</h4>
                    <ul>
                        <li>Sách bị lỗi do nhà sản xuất (thiếu trang, in lộn xộn, mờ chữ...).</li>
                        <li>Giao sai tên sách, sai phiên bản hoặc sai số lượng so với đơn đặt hàng.</li>
                        <li>Sách bị hư hỏng, móp méo nặng trong quá trình vận chuyển.</li>
                    </ul>
                </div>

                <div class="policy-section">
                    <h4 style="color: #e74c3c;">Trường hợp KHÔNG được đổi trả</h4>
                    <ul>
                        <li style="color: #7f8c8d;">Khách hàng thay đổi ý định mua hàng sau khi đã bọc plastic.</li>
                        <li style="color: #7f8c8d;">Sách bị hư hỏng do lỗi bảo quản của khách hàng (đổ nước, cháy xém...).</li>
                        <li style="color: #7f8c8d;">Quá thời hạn 07 ngày kể từ ngày nhận hàng.</li>
                    </ul>
                </div>

                <div class="policy-section">
                    <h4>Quy trình xử lý đổi trả</h4>
                    <div class="highlight-step">
                        <strong>Bước 1:</strong> Liên hệ với BookStore qua Hotline <strong>0909 123 456</strong> hoặc Box Chat.
                    </div>
                    <div class="highlight-step">
                        <strong>Bước 2:</strong> Gửi hàng về địa chỉ kho: <strong>Ninh Kiều, Cần Thơ</strong>.
                    </div>
                    <div class="highlight-step">
                        <strong>Bước 3:</strong> BookStore sẽ gửi lại sách mới (hoặc hoàn tiền) trong vòng 3-5 ngày làm việc.
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #ccc;">
                    <a href="index.php" style="display: inline-block; padding: 10px 25px; background: #C92127; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; transition: 0.3s;">Quay lại trang chủ</a>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>