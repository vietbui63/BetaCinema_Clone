<?php
require 'config.php';

// Set the number of rows per page
$limit = 5;

// Get the current page from the URL, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure it's not less than 1

// Calculate the OFFSET
$offset = ($page - 1) * $limit;

// Query data with pagination
$query = "SELECT * FROM halls ORDER BY CinemaID ASC, HallName ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connect, $query);

// Get the total number of rows to calculate the total number of pages
$total_query = "SELECT COUNT(*) as total FROM halls";
$total_result = mysqli_query($connect, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_halls = $total_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_halls / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Halls</title>
</head>
<body>
<div class="container mt-5">
    <a href="/BetaCinema_Clone/admin/pages/halls/add_halls.php" class="btn btn-success text-center mt-5">THÊM MỚI
        HALL</a>
    <table class="table table-info table-bordered border-info table-striped mt-3">
        <thead>
        <tr class="text-center">
            <th scope="col">ID</th>
            <th scope="col">Hall Name</th>
            <th scope="col">Seat Count</th>
            <th scope="col">Cinema ID</th>
            <th scope="col">Function</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $counter = $offset + 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='text-center'>";
            echo "<td>" . $counter++ . "</td>";
            echo "<td>" . htmlspecialchars($row['HallName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['SeatCount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['CinemaID']) . "</td>";
            echo "<td>
                    <a href='/BetaCinema_Clone/admin/pages/halls/edit_halls.php?id=" . htmlspecialchars($row['HallID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                    <a href='/BetaCinema_Clone/admin/pages/halls/delete_halls.php?id=" . htmlspecialchars($row['HallID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá hall này không?');\">XOÁ</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination navigation -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Pagination">
            <ul class="pagination">
                <!-- Previous button -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next button -->
                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
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
        max-width: 100px;
    }

    tbody td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 50px;
    }
</style>
</html>