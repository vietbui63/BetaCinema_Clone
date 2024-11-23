<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SHOWTIMES</title>
</head>

<body>
    <?php
        require 'config.php';  // Ensure your DB connection is correct

        // Define the number of results per page
        $results_per_page = 5;

        // Get the current page number from the URL, default to 1 if not set
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $current_page = $_GET['page'];
        } else {
            $current_page = 1;
        }

        // Calculate the starting row for the query
        $start_from = ($current_page - 1) * $results_per_page;

        // Modified query with LIMIT to fetch only the records for the current page
        $query = "SELECT st.ShowtimeID, m.MoviesID AS MovieID, m.Title AS MovieTitle, st.ShowDate, st.StartTime, st.EndTime, h.HallName
                  FROM show_times st
                  JOIN movies m ON st.MovieID = m.MoviesID
                  JOIN halls h ON st.HallID = h.HallID
                  ORDER BY m.MoviesID, st.ShowDate, st.StartTime
                  LIMIT $start_from, $results_per_page";

        $result = mysqli_query($connect, $query);

        // Check if query is successful
        if (!$result) {
            die("Query failed: " . mysqli_error($connect));
        }

        // Get the total number of records for pagination
        $total_query = "SELECT COUNT(*) AS total FROM show_times";
        $total_result = mysqli_query($connect, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total_records = $total_row['total'];

        // Calculate total pages
        $total_pages = ceil($total_records / $results_per_page);
    ?>

    <div class="container mt-5">
        <a href="/BetaCinema_Clone/admin/pages/showtimes/add_showtimes.php" class="btn btn-success text-center mt-5">THÊM MỚI SHOWTIMES</a>
        <table class="table table-info table-bordered border-info table-striped mt-3" id="font">
            <thead>
                <tr class="text-center">
                    <th scope="col">Showtime ID</th>
                    <th scope="col">Movie ID</th>
                    <th scope="col">Tên phim</th>
                    <th scope="col">Ngày chiếu</th>
                    <th scope="col">Giờ chiếu</th>
                    <th scope="col">Giờ kết thúc</th>
                    <th scope="col">Phòng chiếu</th>
                    <th scope="col">Function</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Initialize variables
                    $previousMovieID = null;
                    $previousMovieTitle = null;

                    // Loop through the result set and display showtimes
                    while ($row = $result->fetch_assoc()) {
                        // If we are at a new movie, display the movie title once
                        if ($row["MovieID"] != $previousMovieID) {
                            $previousMovieID = $row["MovieID"];
                            $previousMovieTitle = $row["MovieTitle"];
                        }

                        // Display the showtime details for this movie
                        echo "<tr class='text-center'>
                                <td>" . $row["ShowtimeID"] . "</td>
                                <td>" . $row["MovieID"] . "</td>
                                <td>" . $previousMovieTitle . "</td>
                                <td>" . (!empty($row['ShowDate']) ? date("d/m/Y", strtotime($row['ShowDate'])) : "N/A") . "</td>
                                <td>" . $row["StartTime"] . "</td>
                                <td>" . $row["EndTime"] . "</td>
                                <td>" . $row["HallName"] . "</td>
                                <td>
                                    <a href='/BetaCinema_Clone/admin/pages/showtimes/edit_showtimes.php?id=" . htmlspecialchars($row['ShowtimeID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                                    <a href='/BetaCinema_Clone/admin/pages/showtimes/delete_showtimes.php?id=" . htmlspecialchars($row['ShowtimeID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá user này không?');\">XOÁ</a>
                                </td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- First Page Link -->
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=1" aria-label="First">
                            <span aria-hidden="true">&laquo;&laquo;</span> First
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Previous Page Link -->
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span> Previous
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Page Number Links with Range -->
                <?php 
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);

                    // Display the range of page numbers
                    for ($page = $start_page; $page <= $end_page; $page++): 
                        $active_class = ($page == $current_page) ? 'active' : '';
                ?>
                    <li class="page-item <?= $active_class ?>">
                        <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next Page Link -->
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span> Next
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Last Page Link -->
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $total_pages ?>" aria-label="Last">
                            Last <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>

<style>
    thead th {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 200px;
        text-transform: uppercase;
    }

    tbody td {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 150px; 
    }
    #font {
        font-size: 14px;
    }
</style>
</html>
