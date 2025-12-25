-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2024 lúc 08:07 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `csdl_webandouong1`
--
CREATE DATABASE IF NOT EXISTS `csdl_webandouong1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `csdl_webandouong1`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drink_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `drink_id`, `quantity`) VALUES
(2221, 11001, 301901, 1),
(2221, 11001, 301912, 1),
(2222, 11002, 301904, 5),
(2223, 11003, 301905, 3),
(2224, 11004, 301906, 4),
(2225, 11005, 301907, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `drink`
--

CREATE TABLE `drink` (
  `drink_id` int(11) NOT NULL,
  `drink_name` varchar(20) NOT NULL,
  `image` longblob NOT NULL,
  `price` decimal(11,0) NOT NULL,
  `drink_status` enum('Còn hàng','Hết hàng') NOT NULL,
  `category` enum('Hot cafe','Cold cafe') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `drink`
--

INSERT INTO `drink` (`drink_id`, `drink_name`, `image`, `price`, `drink_status`, `category`) VALUES
(301901, 'Cà phê đen ', '', 25, 'Còn hàng', 'Hot cafe'),
(301902, 'Capucchino ', '', 25, 'Còn hàng', 'Hot cafe'),
(301903, 'Espresso ', '', 25, 'Còn hàng', 'Hot cafe'),
(301904, 'Cafe latte ', '', 25, 'Còn hàng', 'Hot cafe'),
(301905, 'Macchiato', '', 25, 'Còn hàng', 'Hot cafe'),
(301906, 'Double Espresso ', '', 25, 'Hết hàng', 'Hot cafe'),
(301907, 'Americano', '', 25, 'Còn hàng', 'Cold cafe'),
(301908, 'Cà phê coldbrew', '', 25, 'Hết hàng', 'Cold cafe'),
(301909, 'Cà phê sữa', '', 25, 'Còn hàng', 'Cold cafe'),
(301910, 'Cappuchino', '', 25, 'Còn hàng', 'Cold cafe'),
(301911, 'Latte', '', 25, 'Còn hàng', 'Cold cafe'),
(301912, 'Mocha', '', 25, 'Còn hàng', 'Cold cafe'),
(301913, 'Cà Phê Nâu', '', 25, 'Còn hàng', 'Hot cafe');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` enum('Đã giao','Đang giao','Đang chuẩn bị','Đã huỷ') DEFAULT NULL,
  `payment_method` enum('Ví điện tử','Thẻ tín dụng','Thanh toán khi nhận hàng') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `order_status`, `payment_method`) VALUES
(20241, 11001, '2024-11-01', 'Đã giao', 'Thẻ tín dụng'),
(20242, 11002, '2024-11-03', 'Đang chuẩn bị', 'Thanh toán khi nhận hàng'),
(20243, 11002, '2024-11-06', 'Đã huỷ', 'Ví điện tử'),
(20244, 11001, '2024-11-11', 'Đang chuẩn bị', 'Thanh toán khi nhận hàng'),
(20245, 11002, '2024-11-15', 'Đang chuẩn bị', 'Ví điện tử'),
(20258, 11006, '2024-11-29', 'Đang chuẩn bị', 'Thẻ tín dụng'),
(20259, 11006, '2024-11-29', 'Đang chuẩn bị', 'Thẻ tín dụng'),
(20260, 11004, '2024-11-29', 'Đã giao', 'Thẻ tín dụng'),
(20262, 11006, '2024-11-29', 'Đang chuẩn bị', 'Thẻ tín dụng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `drink_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `drink_id`, `quantity`, `price`) VALUES
(5551, 20241, 301901, 1, 25),
(5551, 20241, 301912, 1, 25),
(5552, 20242, 301902, 2, 50),
(5553, 20243, 301903, 3, 75),
(5554, 20244, 301904, 4, 100),
(5555, 20245, 301905, 5, 125),
(0, 20258, 301911, 7, 25),
(0, 20259, 301912, 6, 25),
(0, 20260, 301912, 12, 25),
(0, 20261, 301908, 8, 25),
(0, 20262, 301913, 2, 25);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanlysanpham`
--

CREATE TABLE `quanlysanpham` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Còn hàng','Hết hàng') DEFAULT 'Còn hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quanlysanpham`
--

INSERT INTO `quanlysanpham` (`id`, `name`, `price`, `status`) VALUES
(301902, 'Capucchino ', 25.00, 'Còn hàng'),
(301903, 'Espresso ', 25.00, 'Còn hàng'),
(301904, 'Cafe latte ', 25.00, 'Còn hàng'),
(301905, 'Macchiato', 25.00, 'Còn hàng'),
(301906, 'Double Espresso ', 25.00, 'Hết hàng'),
(301907, 'Americano', 25.00, 'Còn hàng'),
(301908, 'Cà phê coldbrew', 25.00, 'Hết hàng'),
(301909, 'Cà phê sữa', 25.00, 'Còn hàng'),
(301910, 'Cappuchino', 25.00, 'Còn hàng'),
(301911, 'Latte', 25.00, 'Còn hàng'),
(301912, 'Mocha', 25.00, 'Còn hàng'),
(301901, 'Cà Phê Đen', 25.00, 'Còn hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `r_date` date NOT NULL,
  `revenue` decimal(20,0) NOT NULL,
  `orders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `report`
--

INSERT INTO `report` (`report_id`, `user_id`, `r_date`, `revenue`, `orders`) VALUES
(241101, 1001, '2024-11-01', 1000, 120),
(241102, 1002, '2024-11-02', 1200, 139),
(241103, 1001, '2024-11-03', 1300, 150),
(241104, 1002, '2024-11-04', 1000, 80),
(241105, 1001, '2024-11-05', 1100, 50),
(241106, 1002, '2024-11-06', 800, 45),
(241107, 1001, '2024-11-07', 950, 55),
(241108, 1002, '2024-11-08', 1300, 130),
(241109, 1001, '2024-11-09', 1300, 130),
(241110, 1002, '2024-11-10', 1200, 110),
(241111, 1001, '2024-11-11', 1500, 140),
(241112, 1002, '2024-11-12', 1000, 100),
(241113, 1002, '2024-11-30', 1800, 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `role` enum('Admin','Khách hàng') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `name`, `phone`, `address`, `role`, `password`) VALUES
(1001, 'Nguyễn Thị A', '0396783840', '76 Trần Bình, Cầu Giấy, Hà Nội', 'Admin', 'nguyenthia'),
(1002, 'Nguyễn Văn B', '0396783841', '77 Trần Bình, Cầu Giấy, Hà Nội', 'Admin', 'nguyenvanb'),
(1003, 'Nguyễn Thị M', '0362537677', '88 Trần Bình, Cầu Giấy, Hà Nội', 'Admin', 'nguyenthim'),
(11001, 'Nguyễn Thị C', '0396783842', '78 Trần Bình, Cầu Giấy, Hà Nội', 'Khách hàng', 'nguyenthic'),
(11002, 'Nguyễn Văn D', '0396783843', '79 Trần Bình, Cầu Giấy, Hà Nội', 'Khách hàng', 'nguyenvand'),
(11003, 'Nguyễn Văn E', '0396783844', '80 Trần Bình, Cầu Giấy, Hà Nội', 'Khách hàng', 'nguyenvane'),
(11004, 'Nguyễn Thị F', '0396783845', '81 Trần Bình, Cầu Giấy, Hà Nội', 'Khách hàng', 'nguyenthif'),
(11005, 'Nguyễn Thị G', '0362537675', '90 Trần Bình, Cầu Giấy, Hà Nội', 'Khách hàng', 'nguyenthig');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `drink_id` (`drink_id`);

--
-- Chỉ mục cho bảng `drink`
--
ALTER TABLE `drink`
  ADD PRIMARY KEY (`drink_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `drink_id` (`drink_id`);

--
-- Chỉ mục cho bảng `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `phone` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `drink`
--
ALTER TABLE `drink`
  MODIFY `drink_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301914;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20263;

--
-- AUTO_INCREMENT cho bảng `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
