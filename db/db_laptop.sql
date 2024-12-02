-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 02, 2024 lúc 04:36 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_laptop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_brand`
--

CREATE TABLE `t_brand` (
  `id` int(11) NOT NULL,
  `shortName` varchar(30) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_brand`
--

INSERT INTO `t_brand` (`id`, `shortName`, `name`, `image`) VALUES
(1, 'DELL', 'Laptop Dell VN', 'brand_673b4c8a4a08e2.78676325.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_features`
--

CREATE TABLE `t_features` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_orders`
--

CREATE TABLE `t_orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `address` varchar(120) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_orders`
--

INSERT INTO `t_orders` (`id`, `userId`, `orderDate`, `totalAmount`, `status`, `address`, `name`, `phone`) VALUES
(3, 1, '2024-11-24 00:15:51', 798000, 'completed', 'Hà Nội', 'SSSS', '123123'),
(6, 1, '2024-11-24 08:30:19', 589000, 'pending', '22222', '22222222', '123123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_order_details`
--

CREATE TABLE `t_order_details` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `totalPrice` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_order_details`
--

INSERT INTO `t_order_details` (`id`, `orderId`, `productId`, `quantity`, `price`, `totalPrice`) VALUES
(2, 3, 1, 2, 399000, 798000),
(7, 6, 2, 1, 0, 0),
(8, 6, 3, 1, 190000, 190000),
(9, 6, 1, 1, 399000, 399000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_payments`
--

CREATE TABLE `t_payments` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product`
--

CREATE TABLE `t_product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `ram` tinyint(4) DEFAULT NULL,
  `ssd` tinyint(4) DEFAULT NULL,
  `hdd` tinyint(4) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `screen` float DEFAULT NULL,
  `cpu` varchar(30) DEFAULT NULL,
  `isDiscount` tinyint(1) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `info` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `brandId` int(11) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL,
  `sold` int(11) DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  `newPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_product`
--

INSERT INTO `t_product` (`id`, `name`, `ram`, `ssd`, `hdd`, `weight`, `screen`, `cpu`, `isDiscount`, `price`, `image`, `description`, `info`, `quantity`, `brandId`, `typeId`, `sold`, `percent`, `newPrice`) VALUES
(1, 'LAPTOP 123', 2, 3, 3, 3, 3, '3', 0, 399000, 'product_673b4ccedd18c6.37633523.jpg', 'SS', 'SS', 12, 1, 1, 2, 0, 0),
(2, 'SSS', 123, 12, 2, 21, 213, '123', 1, 123, 'product_6742f19b0ab943.50001048.jpg', 'S', 'S', 123, 1, 1, 0, 0, 0),
(3, 'Test NewProduct', 12, 21, 21, 121, 21, '21', 1, 200000, 'product_67430f612ffcf6.55016890.jpg', '12', '12', 12, 1, 1, 0, 5, 190000),
(4, 'SP 1', 1, 1, 1, 1, 1, '1', 0, 1, 'product_674dcf31aa19b6.93977427.jpg', '1', '1', 1, 1, 1, 0, 0, 0),
(5, 'SP 2', 1, 1, 1, 1, 1, '1', 0, 1, 'product_674dcf3b6b26f5.39602551.jpg', '2', '2', 1, 1, 1, 0, 0, 0),
(6, 'SP 3', 1, 1, 1, 1, 1, '1', 0, 1, 'product_674dcf4254de12.18561857.jpg', '3', '3', 1, 1, 1, 0, 0, 0),
(7, 'SP 4', 1, 1, 1, 1, 1, '1', 0, 1, 'product_674dcf4b213067.72601995.jpg', '4', '4', 1, 1, 1, 0, 0, 0),
(8, 'SP 5', 1, 1, 1, 1, 1, '1', 0, 1, 'product_674dcf535920d6.83743734.jpg', '5', '5', 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product_discount`
--

CREATE TABLE `t_product_discount` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `discountPercentage` decimal(5,2) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDdate` date DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product_feature`
--

CREATE TABLE `t_product_feature` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `featureId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product_image`
--

CREATE TABLE `t_product_image` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product_special_tech`
--

CREATE TABLE `t_product_special_tech` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `specialtechId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_product_type`
--

CREATE TABLE `t_product_type` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_revenue`
--

CREATE TABLE `t_revenue` (
  `id` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_revenue`
--

INSERT INTO `t_revenue` (`id`, `orderId`, `price`) VALUES
(1, 3, 798000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_roles`
--

CREATE TABLE `t_roles` (
  `id` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_roles`
--

INSERT INTO `t_roles` (`id`, `roleName`, `description`, `role`) VALUES
(1, 'USER', 'Người dùng hệ thống', 'USER'),
(2, 'ADMIN', 'Quản trị hệ thống', 'ADMIN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_shipping`
--

CREATE TABLE `t_shipping` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `shippingAddress` varchar(255) NOT NULL,
  `shippingDate` date DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_shopping_cart`
--

CREATE TABLE `t_shopping_cart` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_shopping_cart`
--

INSERT INTO `t_shopping_cart` (`id`, `userId`, `productId`, `quantity`, `added_at`) VALUES
(10, 1, 3, 1, '2024-11-26 16:14:41'),
(11, 1, 1, 2, '2024-11-26 16:21:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_special_tech`
--

CREATE TABLE `t_special_tech` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_type`
--

CREATE TABLE `t_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_type`
--

INSERT INTO `t_type` (`id`, `name`) VALUES
(1, 'TYP 1111');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_users`
--

INSERT INTO `t_users` (`id`, `username`, `password`, `email`, `image`, `createdAt`, `updatedAt`, `phone`, `address`, `name`) VALUES
(1, '123123', '4297f44b13955235245b2497399d7a93', '123123', NULL, '2024-11-18 14:41:40', '2024-12-02 14:55:37', '123123', '12', 'Laptop Dell 123123123123'),
(3, '20111061199', '57ddf8dc55badf9e7278eeca0bbed7f5', '', NULL, '2024-12-01 11:56:20', '2024-12-01 11:56:20', '20111061199', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_user_roles`
--

CREATE TABLE `t_user_roles` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `t_user_roles`
--

INSERT INTO `t_user_roles` (`id`, `userId`, `roleId`) VALUES
(2, 1, 2),
(1, 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `t_wishlists`
--

CREATE TABLE `t_wishlists` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `addedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `t_brand`
--
ALTER TABLE `t_brand`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `t_features`
--
ALTER TABLE `t_features`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `t_orders`
--
ALTER TABLE `t_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Chỉ mục cho bảng `t_order_details`
--
ALTER TABLE `t_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `t_payments`
--
ALTER TABLE `t_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`);

--
-- Chỉ mục cho bảng `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brand` (`brandId`),
  ADD KEY `fk_type` (`typeId`);

--
-- Chỉ mục cho bảng `t_product_discount`
--
ALTER TABLE `t_product_discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `t_product_feature`
--
ALTER TABLE `t_product_feature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `featureId` (`featureId`);

--
-- Chỉ mục cho bảng `t_product_image`
--
ALTER TABLE `t_product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `t_product_special_tech`
--
ALTER TABLE `t_product_special_tech`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `specialtechId` (`specialtechId`);

--
-- Chỉ mục cho bảng `t_product_type`
--
ALTER TABLE `t_product_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `typeId` (`typeId`);

--
-- Chỉ mục cho bảng `t_revenue`
--
ALTER TABLE `t_revenue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`);

--
-- Chỉ mục cho bảng `t_roles`
--
ALTER TABLE `t_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roleName` (`roleName`);

--
-- Chỉ mục cho bảng `t_shipping`
--
ALTER TABLE `t_shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`);

--
-- Chỉ mục cho bảng `t_shopping_cart`
--
ALTER TABLE `t_shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Chỉ mục cho bảng `t_special_tech`
--
ALTER TABLE `t_special_tech`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `t_type`
--
ALTER TABLE `t_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `t_user_roles`
--
ALTER TABLE `t_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`,`roleId`),
  ADD KEY `roleId` (`roleId`);

--
-- Chỉ mục cho bảng `t_wishlists`
--
ALTER TABLE `t_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `t_brand`
--
ALTER TABLE `t_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `t_features`
--
ALTER TABLE `t_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_orders`
--
ALTER TABLE `t_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `t_order_details`
--
ALTER TABLE `t_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `t_payments`
--
ALTER TABLE `t_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_product`
--
ALTER TABLE `t_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `t_product_discount`
--
ALTER TABLE `t_product_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_product_feature`
--
ALTER TABLE `t_product_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_product_image`
--
ALTER TABLE `t_product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_product_special_tech`
--
ALTER TABLE `t_product_special_tech`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_product_type`
--
ALTER TABLE `t_product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_revenue`
--
ALTER TABLE `t_revenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `t_roles`
--
ALTER TABLE `t_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `t_shipping`
--
ALTER TABLE `t_shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_shopping_cart`
--
ALTER TABLE `t_shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `t_special_tech`
--
ALTER TABLE `t_special_tech`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `t_type`
--
ALTER TABLE `t_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `t_user_roles`
--
ALTER TABLE `t_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `t_wishlists`
--
ALTER TABLE `t_wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `t_orders`
--
ALTER TABLE `t_orders`
  ADD CONSTRAINT `t_orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_order_details`
--
ALTER TABLE `t_order_details`
  ADD CONSTRAINT `t_order_details_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `t_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_order_details_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_payments`
--
ALTER TABLE `t_payments`
  ADD CONSTRAINT `t_payments_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `t_orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product`
--
ALTER TABLE `t_product`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brandId`) REFERENCES `t_brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_type` FOREIGN KEY (`typeId`) REFERENCES `t_type` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product_discount`
--
ALTER TABLE `t_product_discount`
  ADD CONSTRAINT `t_product_discount_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product_feature`
--
ALTER TABLE `t_product_feature`
  ADD CONSTRAINT `t_product_feature_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_product_feature_ibfk_2` FOREIGN KEY (`featureId`) REFERENCES `t_features` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product_image`
--
ALTER TABLE `t_product_image`
  ADD CONSTRAINT `t_product_image_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product_special_tech`
--
ALTER TABLE `t_product_special_tech`
  ADD CONSTRAINT `t_product_special_tech_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_product_special_tech_ibfk_2` FOREIGN KEY (`specialtechId`) REFERENCES `t_special_tech` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_product_type`
--
ALTER TABLE `t_product_type`
  ADD CONSTRAINT `t_product_type_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_product_type_ibfk_2` FOREIGN KEY (`typeId`) REFERENCES `t_type` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_revenue`
--
ALTER TABLE `t_revenue`
  ADD CONSTRAINT `t_revenue_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `t_orders` (`id`);

--
-- Các ràng buộc cho bảng `t_shipping`
--
ALTER TABLE `t_shipping`
  ADD CONSTRAINT `t_shipping_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `t_orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_shopping_cart`
--
ALTER TABLE `t_shopping_cart`
  ADD CONSTRAINT `t_shopping_cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_shopping_cart_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_user_roles`
--
ALTER TABLE `t_user_roles`
  ADD CONSTRAINT `t_user_roles_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_user_roles_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `t_roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `t_wishlists`
--
ALTER TABLE `t_wishlists`
  ADD CONSTRAINT `t_wishlists_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `t_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_wishlists_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `t_product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
