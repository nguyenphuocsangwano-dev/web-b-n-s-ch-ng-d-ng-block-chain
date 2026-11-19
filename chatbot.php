<style>
    /* =========================================
       CSS CHO MINI CHAT
       ========================================= */
    #chat-circle-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        font-size: 11px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        z-index: 999999 !important;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.2;
    }
    #chat-circle-btn:hover {
        transform: scale(1.1);
        background-color: #e74c3c;
    }

    #chat-popup {
        display: none;
        position: fixed;
        bottom: 110px;
        right: 30px;
        width: 320px;
        height: 420px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 999999 !important;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #ddd;
    }

    .chat-header {
        background-color: #2c3e50;
        color: white;
        padding: 15px;
        font-weight: bold;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .close-chat {
        cursor: pointer;
        font-size: 20px;
    }
    .close-chat:hover {
        color: #e74c3c;
    }

    .chat-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
    }

    .bot-msg {
        background-color: #e0e0e0;
        color: #333;
        padding: 10px;
        border-radius: 15px 15px 15px 0;
        margin-bottom: 10px;
        max-width: 85%;
        font-size: 14px;
        line-height: 1.4;
        align-self: flex-start;
    }

    .chat-options {
        padding: 10px 15px;
        background: #fff;
        border-top: 1px solid #eee;
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 120px; /* Thêm giới hạn chiều cao cho menu hỏi */
        overflow-y: auto;  /* Thêm thanh cuộn nếu có quá nhiều câu hỏi */
    }
    .faq-btn {
        background-color: #fff;
        color: #2c3e50;
        border: 1px solid #2c3e50;
        border-radius: 20px;
        padding: 8px 12px;
        font-size: 13px;
        cursor: pointer;
        text-align: left;
        transition: 0.2s;
    }
    .faq-btn:hover {
        background-color: #2c3e50;
        color: #fff;
    }
</style>

<div id="mini-chat-wrapper">
    <button id="chat-circle-btn" onclick="toggleChat()">BOOK<br>STORE</button>

    <div id="chat-popup">
        <div class="chat-header">
            <span>Hỗ trợ trực tuyến</span>
            <span class="close-chat" onclick="toggleChat()">✖</span>
        </div>
        
        <div class="chat-body" id="chat-body">
            <div class="bot-msg">
                Chào bạn! 👋 Mình là trợ lý ảo của BookStore. Bạn cần tìm hiểu thông tin gì ạ?
            </div>
        </div>

        <div class="chat-options" id="chat-options">
            <?php
            // Lấy các câu hỏi từ Database (nơi Admin quản lý)
            if(isset($conn)) {
                $sql_faq = "SELECT * FROM chat_faq WHERE trang_thai = 1";
                $result_faq = mysqli_query($conn, $sql_faq);
                
                if ($result_faq && mysqli_num_rows($result_faq) > 0) {
                    while ($faq = mysqli_fetch_assoc($result_faq)) {
                        echo '<button class="faq-btn" onclick="askBot(this)" data-answer="'.htmlspecialchars($faq['cau_tra_loi']).'">'.htmlspecialchars($faq['cau_hoi']).'</button>';
                    }
                } else {
                    echo '<span style="font-size:13px; color:#666;">Chưa có câu hỏi nào. Admin cần thêm vào!</span>';
                }
            } else {
                echo '<span style="font-size:13px; color:red;">Lỗi kết nối cơ sở dữ liệu!</span>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    // Bật tắt khung chat
    function toggleChat() {
        var popup = document.getElementById("chat-popup");
        if (popup.style.display === "none" || popup.style.display === "") {
            popup.style.display = "flex";
        } else {
            popup.style.display = "none";
        }
    }

    // Xử lý khi khách hàng bấm vào câu hỏi
    function askBot(btnElement) {
        var question = btnElement.innerText;
        var answer = btnElement.getAttribute("data-answer"); 
        var chatBody = document.getElementById("chat-body");

        // ĐÃ SỬA LỖI Ở ĐÂY: Xóa dòng ẩn "chat-options" đi để khách bấm hỏi tiếp được!
        // document.getElementById("chat-options").style.display = "none"; 

        // Hiện tin nhắn của khách (màu đỏ)
        var userMsg = document.createElement("div");
        userMsg.className = "bot-msg";
        userMsg.style.backgroundColor = "#C92127";
        userMsg.style.color = "white";
        userMsg.style.borderRadius = "15px 15px 0 15px";
        userMsg.style.alignSelf = "flex-end";
        userMsg.innerText = question;
        chatBody.appendChild(userMsg);

        // Cuộn xuống cuối
        chatBody.scrollTop = chatBody.scrollHeight;

        // Bot giả vờ suy nghĩ rồi trả lời sau 0.5s
        setTimeout(function() {
            var botReply = document.createElement("div");
            botReply.className = "bot-msg";
            botReply.style.borderRadius = "15px 15px 15px 0";
            botReply.innerText = answer;
            chatBody.appendChild(botReply);
            
            // Cuộn xuống cuối
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 500);
    }
</script>