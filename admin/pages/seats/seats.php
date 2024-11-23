<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SEATS</title>
</head>
<body>
<?php
require 'config.php';  // Kết nối cơ sở dữ liệu

// Thiết lập số hàng mỗi trang
$limit = 5;

// Lấy trang hiện tại từ URL, mặc định là 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Đảm bảo không nhỏ hơn 1

// Tính toán OFFSET
$offset = ($page - 1) * $limit;

// Lọc Hall ID nếu được chọn
$hall_id_filter = isset($_GET['hall_id']) ? $_GET['hall_id'] : '';

// Truy vấn danh sách các HallID
$halls_query = "SELECT DISTINCT HallID FROM seats";
$halls_result = mysqli_query($connect, $halls_query);

// Truy vấn danh sách ghế dựa trên bộ lọc HallID và sắp xếp theo HallID và SeatNumber
$query = "SELECT * FROM seats";
if (!empty($hall_id_filter)) {
    $query .= " WHERE HallID = '" . mysqli_real_escape_string($connect, $hall_id_filter) . "'";
}

// Thêm phân trang vào truy vấn
$query .= " ORDER BY HallID ASC, SeatNumber ASC LIMIT $limit OFFSET $offset";

// Thực thi truy vấn
$result = mysqli_query($connect, $query);

// Truy vấn để đếm tổng số ghế (cho phân trang)
$count_query = "SELECT COUNT(*) as total FROM seats";
if (!empty($hall_id_filter)) {
    $count_query .= " WHERE HallID = '" . mysqli_real_escape_string($connect, $hall_id_filter) . "'";
}
$count_result = mysqli_query($connect, $count_query);
$total_row = mysqli_fetch_assoc($count_result);
$total_seats = $total_row['total'];

// Tính tổng số trang
$total_pages = ceil($total_seats / $limit);
?>
<div class="container mt-5">
    <form method="GET" class="mb-6">
        <div class="row align-items-center">
            <!-- Nút thêm mới ghế -->
            <div class="col-md-6 text-start">
                <a href="/BetaCinema_Clone/admin/pages/seats/add_seats.php" class="btn btn-success">THÊM MỚI SEAT</a>
            </div>
            <!-- Thanh chọn lọc và nút lọc căn phải -->
            <div class="col-md-6 text-end d-flex justify-content-end gap-4">
                <!-- Thanh lọc Hall ID -->
                <select name="hall_id" class="form-select w-auto">
                    <option value="">-- Chọn Hall ID --</option>
                    <?php
                    while ($hall = mysqli_fetch_assoc($halls_result)) {
                        $selected = ($hall_id_filter == $hall['HallID']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($hall['HallID']) . "' $selected>Hall ID " . htmlspecialchars($hall['HallID']) . "</option>";
                    }
                    ?>
                </select>
                <!-- Nút lọc -->
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <!-- Bảng hiển thị dữ liệu -->
    <table class="table table-info table-bordered border-info table-striped mt-3">
        <thead>
        <tr class="text-center">
            <th scope="col">ID</th>
            <th scope="col">Số Ghế</th>
            <th scope="col">VIP</th>
            <th scope="col">Couple</th>
            <th scope="col">Hall ID</th>
            <th scope="col">Function</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $counter = $offset + 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='text-center'>";
            echo "<td>" . $counter++ . "</td>";
            echo "<td>" . htmlspecialchars($row['SeatNumber']) . "</td>";
            echo "<td>" . ($row['VIP'] == '1' ? 'Có' : 'Không') . "</td>";
            echo "<td>" . ($row['Couple'] == '1' ? 'Có' : 'Không') . "</td>";
            echo "<td>" . htmlspecialchars($row['HallID']) . "</td>";
            echo "<td>
                            <a href='/BetaCinema_Clone/admin/pages/seats/edit_seats.php?id=" . htmlspecialchars($row['SeatID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                            <a href='/BetaCinema_Clone/admin/pages/seats/delete_seats.php?id=" . htmlspecialchars($row['SeatID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá ghế này không?');\">XOÁ</a>
                          </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Điều hướng phân trang -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Pagination">
            <ul class="pagination">
                <!-- Nút Previous -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="?hall_id=<?php echo $hall_id_filter; ?>&page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <!-- Hiển thị số trang -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link"
                           href="?hall_id=<?php echo $hall_id_filter; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Nút Next -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="?hall_id=<?php echo $hall_id_filter; ?>&page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
</body>
<style>
    thead th {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 20px;
    }

    tbody td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 50px;
    }
</style>
</html>