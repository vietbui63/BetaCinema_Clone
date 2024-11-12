-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 08:34 AM
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
-- Database: `betacinema_clone`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `BookingDate` date NOT NULL DEFAULT current_timestamp(),
  `TotalPrice` decimal(10,0) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ShowtimeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `CinemaID` int(11) NOT NULL,
  `CinemaName` varchar(50) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Hotline` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`CinemaID`, `CinemaName`, `Location`, `Hotline`) VALUES
(1, 'Beta Nha Trang', 'Khánh Hoà', '0399475165'),
(2, 'Beta Thanh Xuân', 'Hà Nội', '0824812878'),
(3, 'Beta Mỹ Đình', 'Hà Nội', '0866154610'),
(4, 'Beta Trần Quang Khải', 'TP. Hồ Chí Minh', '1900638362'),
(5, 'Beta Quang Trung', 'TP. Hồ Chí Minh', '0706075509');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `HallID` int(11) NOT NULL,
  `HallName` varchar(50) NOT NULL,
  `SeatCount` int(11) NOT NULL,
  `CinemaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`HallID`, `HallName`, `SeatCount`, `CinemaID`) VALUES
(1, 'P1', 104, 1),
(2, 'P2', 104, 1),
(3, 'P3', 104, 1),
(4, 'P4', 117, 1),
(5, 'P1', 100, 2),
(6, 'P2', 105, 2),
(7, 'P3', 107, 2),
(8, 'P1', 107, 3),
(9, 'P2', 104, 3),
(10, 'P3', 117, 3),
(11, 'P4', 117, 3),
(12, 'P1', 137, 4),
(13, 'P2', 137, 4),
(14, 'P1', 107, 5),
(15, 'P2', 117, 5);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `MoviesID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Genre` varchar(50) NOT NULL,
  `Duration` int(11) NOT NULL,
  `ReleaseDate` date NOT NULL,
  `Pic` text NOT NULL,
  `Trailer` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `SpecialShow` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`MoviesID`, `Title`, `Type`, `Genre`, `Duration`, `ReleaseDate`, `Pic`, `Trailer`, `status`, `SpecialShow`) VALUES
(1, 'Red One: Mật Mã Đỏ', '2D Phụ đề', 'Hài hước, Hành động', 123, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f11%2f04%2f400x633%2D15%2D134009%2D041124%2D68.jpg', 'https://www.youtube.com/watch?v=m6MF1MqsDhc', 'Phim đang chiếu', 1),
(2, 'Thần Dược', '2D Phụ đề', 'Kinh dị, Tâm lý', 138, '2024-11-01', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f23%2f011124%2Dthan%2Dduoc%2D150349%2D231024%2D98.png', 'https://www.youtube.com/watch?v=dNwuFYhwTAk&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 1),
(3, 'Venom: Kèo Cuối', '2D Phụ đề', 'Khoa học, viễn tưởng', 109, '2024-10-25', 'https://files.betacorp.vn/media%2fimages%2f2024%2f09%2f19%2fscreenshot%2D2024%2D09%2D19%2D150036%2D150139%2D190924%2D38.png', 'https://www.youtube.com/watch?time_continue=1&v=b1Yqng0uSWM&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 1),
(4, 'Ngày Xưa Có Một Chuyện Tình', '2D Phụ đề', 'Tình cảm', 135, '2024-10-25', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f23%2f011124%2Dsneak%2Dngay%2Dxua%2Dco%2Dmot%2Dchuyen%2Dtinh%2D135154%2D231024%2D14.png', 'https://www.youtube.com/watch?v=IcpKkCzvcU4&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 1),
(5, 'Linh Miêu', '2D Phụ đề', 'Kinh dị', 110, '2024-11-22', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f14%2f400x633%2D114106%2D141024%2D83.jpg', 'https://www.youtube.com/watch?v=4oxoPMxBO6s&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 0),
(6, 'Tee Yod: Quỷ Ăn Tạng Phần 2', '2D Phụ đề', 'Kinh dị', 111, '2024-10-18', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f15%2f400wx633h%2D3%2D163518%2D151024%2D56.jpg', 'https://www.youtube.com/watch?v=Tx5JuN-5n8U&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 1),
(7, 'Cười Xuyên Biên Giới', '2D Phụ đề', 'Hài hước', 113, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f11%2f08%2f400wx633h%2D1%2D154452%2D081124%2D12.jpg', 'https://www.youtube.com/watch?v=_IK-eb2AbKQ&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim đang chiếu', 0),
(8, 'Học Viện Anh Hùng: You\'re Next', '2D Phụ đề', 'Hoạt hình', 110, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f15%2fscreenshot%2D2024%2D10%2D15%2D145811%2D145844%2D151024%2D25.png', 'https://www.youtube.com/watch?v=O_JcwpDergM', 'Phim đang chiếu', 1),
(9, 'Cu Li Không Bao Giờ Khóc', '2D Phụ đề', 'Kịch', 93, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f22%2fscreenshot%2D2024%2D10%2D22%2D134228%2D134311%2D221024%2D56.png', 'https://www.youtube.com/watch?v=kMjlJkmt5nk&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(10, 'Rebellious', '2D Phụ đề', 'Hoạt hình', 94, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f16%2fscreenshot%2D2024%2D10%2D16%2D151244%2D151347%2D161024%2D13.png', 'https://www.youtube.com/watch?v=98GOZuXSWLY&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(11, 'Võ Sĩ Giác Đấu II', '2D Phụ đề', 'Hành động, Hài hước', 120, '2024-11-15', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f23%2f151124%2Dgladiator%2Dii%2D135227%2D231024%2D46.jpg', 'https://www.youtube.com/watch?v=4rgYUipGJNo&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(12, 'Wicked', '2D Phụ đề', 'Âm Nhạc, Phiêu lưu', 160, '2024-11-22', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f24%2fwicked%2Dforest%2Dduo%2D4x5%2D130600%2D241024%2D57.jpg', 'https://www.youtube.com/watch?time_continue=1&v=6COmYeLsz4c&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(13, 'Chiến Địa Tử Thi', '2D Phụ đề', 'Hành động, Kinh dị', 110, '2024-11-29', 'https://files.betacorp.vn/media%2fimages%2f2024%2f08%2f21%2fposter%2Dchien%2Ddia%2Dtu%2Dthi%2D110045%2D210824%2D25.jpg', 'https://www.youtube.com/watch?v=U4xymqKFehY&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(14, 'Hành Trình Của Moana 2', '2D Phụ đề', 'Phiêu lưu, Hoạt hình', 100, '2024-11-29', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f15%2fscreenshot%2D2024%2D10%2D15%2D135233%2D135334%2D151024%2D46.png', 'https://www.youtube.com/watch?v=hDZ7y8RP5HE&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(15, 'Công Tử Bạc Liêu', '2D Phụ đề', 'Tâm lý, Hài hước', 100, '2024-12-06', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f16%2f400wx633h%2D162649%2D161024%2D28.jpg', 'https://www.youtube.com/watch?v=bmkR2EY_hcY&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1),
(16, 'Chúa Tể Của Những Chiếc Nhẫn: ...', '2D Phụ đề', 'Hành động, Phiêu lưu, Thần thoại', 130, '2024-12-13', 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f21%2fscreenshot%2D2024%2D10%2D21%2D140406%2D140455%2D211024%2D18.png', 'https://www.youtube.com/watch?v=ST08liEjNsw&embeds_referring_euri=https%3A%2F%2Fbetacinemas.vn%2F&source_ve_path=Mjg2NjY', 'Phim sắp chiếu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL DEFAULT current_timestamp(),
  `PaymentMethod` enum('Thẻ','Tiền mặt') NOT NULL,
  `status` enum('Thành công','Thất bại') NOT NULL,
  `BookingID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `SeatID` int(11) NOT NULL,
  `SeatNumber` int(11) NOT NULL,
  `HallID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `show_times`
--

CREATE TABLE `show_times` (
  `ShowtimeID` int(11) NOT NULL,
  `ShowDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `MovieID` int(11) NOT NULL,
  `HallID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `show_times`
--

INSERT INTO `show_times` (`ShowtimeID`, `ShowDate`, `StartTime`, `EndTime`, `MovieID`, `HallID`) VALUES
(1, '2024-11-12', '13:50:00', '15:53:00', 1, 2),
(2, '2024-11-12', '19:00:00', '21:03:00', 1, 1),
(3, '2024-11-12', '20:00:00', '22:03:00', 1, 2),
(4, '2024-11-12', '22:10:00', '00:13:00', 1, 2),
(5, '2024-11-13', '10:30:00', '12:33:00', 1, 4),
(6, '2024-11-13', '13:50:00', '15:53:00', 1, 2),
(7, '2024-11-13', '19:00:00', '21:03:00', 1, 1),
(8, '2024-11-14', '10:30:00', '12:33:00', 1, 4),
(9, '2024-11-14', '13:50:00', '15:53:00', 1, 2),
(10, '2024-11-14', '19:00:00', '21:03:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `TicketID` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `SeatID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Pass_word` varchar(100) NOT NULL,
  `Dob` date NOT NULL,
  `Sex` enum('Nam','Nữ','Khác') NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Fullname`, `Email`, `Pass_word`, `Dob`, `Sex`, `Phone`, `Role`) VALUES
(8, 'Nguyễn Huy Toàn', 'toan.nh.63cntt@ntu.edu.vn', '$2y$10$hFXXuA/ydOES7/KKFqAqx.aB6OaQfAEYOiRLpU.lRNutmnzMVFg.6', '2024-10-30', 'Nam', '123', 0),
(9, 'Nguyen Huy Toan', 'nguyenhuytoan1432k3@gmail.com', '$2y$10$O0xgWOOv3uKUWLDeGxkixuZ0c6GJGyfNu5V45xVDc82Tu0Oo1FQWW', '2024-11-24', 'Nam', '0935941419', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ShowtimeID` (`ShowtimeID`);

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`CinemaID`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`HallID`),
  ADD KEY `CinemaID` (`CinemaID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MoviesID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`SeatID`),
  ADD KEY `HallID` (`HallID`);

--
-- Indexes for table `show_times`
--
ALTER TABLE `show_times`
  ADD PRIMARY KEY (`ShowtimeID`),
  ADD KEY `MovieID` (`MovieID`),
  ADD KEY `HallID` (`HallID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `SeatID` (`SeatID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `CinemaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `HallID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `MoviesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `show_times`
--
ALTER TABLE `show_times`
  MODIFY `ShowtimeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `FK_Bookings_Showtimes` FOREIGN KEY (`ShowtimeID`) REFERENCES `show_times` (`ShowtimeID`),
  ADD CONSTRAINT `FK_Bookings_Users` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `FK_Halls_Cinemas` FOREIGN KEY (`CinemaID`) REFERENCES `cinemas` (`CinemaID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK_Payments_Bookings` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `FK_Seat_Halls` FOREIGN KEY (`HallID`) REFERENCES `halls` (`HallID`);

--
-- Constraints for table `show_times`
--
ALTER TABLE `show_times`
  ADD CONSTRAINT `FK_Showtimes_Halls` FOREIGN KEY (`HallID`) REFERENCES `halls` (`HallID`),
  ADD CONSTRAINT `FK_Showtimes_Movies` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MoviesID`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_Tickets_Bookings` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`),
  ADD CONSTRAINT `FK_Tickets_Seats` FOREIGN KEY (`SeatID`) REFERENCES `seats` (`SeatID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
