<?php
// Kết nối tới file cấu hình cơ sở dữ liệu
include './config.php';

// Kiểm tra nếu không nhận được ID của Hall
if (!isset($_GET['id'])) {
    die("HallID không được cung cấp.");
}

// Lấy HallID từ tham số GET
$id = intval($_GET['id']);

// Kiểm tra xem Hall có tồn tại hay không
$query = "SELECT * FROM halls WHERE HallID = $id";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Hall không tồn tại.");
}

// Thực hiện xóa Hall dựa trên HallID
$deleteQuery = "DELETE FROM halls WHERE HallID = $id";
if (mysqli_query($connect, $deleteQuery)) {
    // Sau khi xóa, chuyển hướng về trang danh sách Halls
    header("Location: /BetaCinema_Clone/admin/pages/index.php");
    exit();
} else {
    // Hiển thị lỗi nếu quá trình xóa thất bại
    die("Lỗi khi xóa Hall: " . mysqli_error($connect));
}
?>
