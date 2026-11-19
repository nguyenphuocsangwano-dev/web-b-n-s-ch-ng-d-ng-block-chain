<?php
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, 'UTF8');
if (!$conn) { die("Kết nối thất bại: " . mysqli_connect_error()); }
?>