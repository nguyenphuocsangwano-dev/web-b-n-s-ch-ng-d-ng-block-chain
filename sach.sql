-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2026 at 05:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `sach`
--

CREATE TABLE `sach` (
  `id` int(11) NOT NULL,
  `ten_sach` varchar(255) NOT NULL,
  `danhmuc` varchar(100) NOT NULL,
  `gia` int(11) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL,
  `tac_gia` varchar(150) DEFAULT 'Đang cập nhật',
  `mota` text DEFAULT NULL,
  `nha_xuat_ban` varchar(100) DEFAULT 'NXB Trẻ / NXB Kim Đồng',
  `ma_xac_thuc_blockchain` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sach`
--

INSERT INTO `sach` (`id`, `ten_sach`, `danhmuc`, `gia`, `hinh_anh`, `tac_gia`, `mota`, `nha_xuat_ban`, `ma_xac_thuc_blockchain`) VALUES
(1, 'Bài Giảng Cuối Cùng', 'Sách Hay', 95000, 'baigiangcuoicung.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Bài Giảng Cuối Cùng. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x467fa1a048716410988089662756b4d4fc97c2080f11788f6e8b3f7a4513cc82'),
(2, 'Bảy Bước Tới Mùa Hè', 'Văn Học', 88000, 'baybuoctoimuahe.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Bảy Bước Tới Mùa Hè. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0xf74a22cefe1782c1b50a13df4be73c6c882060fa9ae6f07b07232f4cd47f484d'),
(3, 'Cha Giàu Cha Nghèo', 'Kinh Tế', 115000, 'chagiauchangheo.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Cha Giàu Cha Nghèo. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0xc61d6fd44a5273dc4a008cc3196567476e3586d1c5665c2a3c6a1bf6a5c7f443'),
(4, 'Đắc Nhân Tâm', 'Sách Hay', 86000, 'dacnhantam.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Đắc Nhân Tâm. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0xb81056c15a3c6836531fa4e47dda5c0710062d653533b1a20f3f13ef941d119b'),
(5, 'Design Patterns - Elements of Reusable Object-Oriented Software', 'Sách IT', 250000, 'designpatterns.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Design Patterns - Elements of Reusable Object-Oriented Software. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x7faae2751a37bcbafc97dfe5f11c2a81b4880cd996b45908501379021a92acd5'),
(6, 'Doraemon - Chú Mèo Máy Đến Từ Tương Lai (Tập 10)', 'Truyện', 25000, 'doraemon.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Doraemon - Chú Mèo Máy Đến Từ Tương Lai (Tập 10). Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x2b7a34650a50758c61080a0904b06fcd77ef57cd5bfe7744a81b236af0c5626c'),
(7, 'Tớ Học Lập Trình - Làm Quen Với Python', 'Sách IT', 135000, 'laptrinhcanban.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Tớ Học Lập Trình - Làm Quen Với Python. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x39c51d74dfde09df0a7d6fcf32c819520482f443b235513ad7e1134edc7c22fa'),
(8, 'Lập Trình PHP Căn Bản', 'Sách IT', 120000, 'laptrinhPHP.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Lập Trình PHP Căn Bản. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x2a83af8154846fdc8dd331ac16f2f3b3fae78e5ad0efb40fbe075243e45c3871'),
(9, 'Nhà Giả Kim', 'Văn Học', 79000, 'nhagiakim.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Nhà Giả Kim. Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0xa764b782ea9474fcf405d151d4277e258288131da5a254b9c65f400fd9647d64'),
(10, 'Sherlock Holmes Toàn Tập (Tập 2)', 'Truyện', 145000, 'sherlockholmes.jpg', 'Đang cập nhật', 'Sách bản quyền chính hãng: Sherlock Holmes Toàn Tập (Tập 2). Được niêm phong và xác thực nguồn gốc xuất bản trên sổ cái Blockchain.', 'NXB Trẻ / NXB Kim Đồng', '0x9bcd188fcb72cb5cd04e767f2a35e8e727a828079ca4d0e41acd0e8cdd69c9e4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sach`
--
ALTER TABLE `sach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
