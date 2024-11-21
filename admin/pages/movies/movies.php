<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>MOVIES</title>
</head>
<body>
    <?php
        require 'config.php';
        $query = "SELECT * FROM movies";
        $result = mysqli_query($connect, $query);
    ?>
    
    <div class="container">
        <a href="/BetaCinema_Clone/admin/pages/movies/add_movies.php" class="btn btn-success text-center mt-3">THÊM MỚI MOVIE</a>
        <table class="table table-info table-bordered border-info table-striped mt-3">
            <thead>
            <tr class="text-center">
                <th scope="col">ID</th>
                <th scope="col">Tên</th>
                <th scope="col">Dimensional</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Thời lượng</th>
                <th scope="col">Ngày khởi chiếu</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Trailer</th>
                <th scope="col">Status</th>
                <th scope="col">Special Show</th>
                <th scope="col">Function</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='text-center'>";
                echo "<td>" . htmlspecialchars($row['MoviesID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Genre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Duration']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ReleaseDate']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['Pic']) . "' alt='" . htmlspecialchars($row['Title']) . "' style='width:50px;height:50px;'></td>";
                echo "<td><a href='" . htmlspecialchars($row['Trailer']) . "' target='_blank'>Trailer</a></td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SpecialShow']) . "</td>";
                echo "<td>
                        <a href='/BetaCinema_Clone/admin/pages/movies/edit_movies.php?movie_id=" . htmlspecialchars($row['MoviesID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                        <a href='/BetaCinema_Clone/admin/pages/movies/delete_movies.php?movie_id=" . htmlspecialchars($row['MoviesID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá movie này không?');\">XOÁ</a>
                    </td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
<style>
    thead th {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    tbody td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }
</style>
</html>