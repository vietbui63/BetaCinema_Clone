<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn ghế</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="/BetaCinema_Clone/js/chon_ghe.js"></script>
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/chon_ghe.css'>

</head>
<body>
    <?php
        require 'config.php';

        // Nhận dữ liệu từ form
        $cinema_id = $_POST['cinema_id'];
        $movie_id = $_POST['movie_id'];
        $show_date = $_POST['showdate'];
        $start_time = $_POST['starttime'];

        // Lấy thông tin phim
        $query_movie = "SELECT * FROM `movies` WHERE MoviesID = '$movie_id'";
        $result_movie = mysqli_query($connect, $query_movie);
        if (!$result_movie) {
            die("Query failed: " . mysqli_error($connect));
        }
        $movie = mysqli_fetch_assoc($result_movie);
        $movie_title = $movie['Title'];
        $movie_pic = $movie['Pic'];
        $movie_type = $movie['Type'];
        $movie_genra = $movie['Genre'];
        $movie_duration = $movie['Duration'];

        // Lấy tên rạp chiếu từ bảng cinemas
        $query_cinema = "SELECT CinemaName FROM `cinemas` WHERE CinemaID = '$cinema_id'";
        $result_cinema = mysqli_query($connect, $query_cinema);
        if (!$result_cinema) {
            die("Query failed: " . mysqli_error($connect));
        }
        $cinema = mysqli_fetch_assoc($result_cinema);
        $cinema_name = $cinema['CinemaName'];

        // Lấy HallID và HallName từ bảng show_times và halls
        $query_hall = "
            SELECT halls.HallID, halls.HallName 
            FROM `show_times`
            JOIN `halls` ON show_times.HallID = halls.HallID
            WHERE show_times.MovieID = '$movie_id' AND show_times.ShowDate = '$show_date' AND show_times.StartTime = '$start_time'
        ";
        $result_hall = mysqli_query($connect, $query_hall);
        if (!$result_hall) {
            die("Query failed: " . mysqli_error($connect));
        }
        $hall = mysqli_fetch_assoc($result_hall);
        $hall_id = $hall['HallID'];
        $hall_name = $hall['HallName'];

        // Truy vấn bảng seats để lấy các SeatNumber theo HallID
        $query_seats = "SELECT * FROM `seats` WHERE HallID = '$hall_id'";
        $result_seats = mysqli_query($connect, $query_seats);
        if (!$result_seats) {
            die("Query failed: " . mysqli_error($connect));
        }
    ?>

    <div class="container mt-5">
        <form action="/BetaCinema_Clone/pages/thanh_toan.php" method="post">
            <div class="row">
                <!-- CHỌN GHẾ -->
                <div class="col-12 col-md-6 mb-4 mb-md-0 mt-5">
                    <div class="row p-3">
                        <img src="/BetaCinema_Clone/assets/ic-screen.png" alt="Logo" class="img-fluid">
                        <p class="text-start mb-4" style="font-size: 20px">Lối Vào</p>
                        <?php
                            $counter = 0; 
                            echo '<div class="d-flex flex-wrap justify-content-center gap-3">'; 
                            while ($row_seat = mysqli_fetch_assoc($result_seats)) {
                                $seat_number = htmlspecialchars($row_seat['SeatNumber']);
                                $is_vip = $row_seat['VIP']; 
                                $is_couple = $row_seat['Couple']; 

                                if ($is_vip == 1) {
                                    $btn_class = 'btn-info'; // GHẾ VIP
                                    $seat_type = 'vip';
                                } elseif ($is_couple == 1) {
                                    $btn_class = 'btn-warning'; // GHẾ COUPLE
                                    $seat_type = 'couple';
                                } else {
                                    $btn_class = 'btn-secondary'; // GHẾ THƯỜNG
                                    $seat_type = 'regular';
                                }

                                if ($counter % 5 == 0 && $counter > 0) {
                                    echo '</div><div class="d-flex flex-wrap justify-content-center gap-3">'; 
                                }

                                echo '<div class="col-4 col-sm-3 col-md-2 mb-3">';
                                echo '<button type="button" class="btn ' . $btn_class . ' w-100" onclick="toggleSeat(this, \'' . $seat_type . '\', \'' . $seat_number . '\')">' . $seat_number . '</button>';
                                echo '</div>';
                                $counter++; 
                            }
                            echo '</div>'; 
                        ?>

                        <div class="row kindofseat">
                            <div class="col mt-4 me-5" style="background-color: #6c757d">
                                <h5>Ghế thường <br>(45.000 VNĐ)</h5>
                            </div>
                            <div class="col mt-4 me-5" style="background-color: #0dcaf0">
                                <h5>Ghế VIP <br>(70.000 VNĐ)</h5>
                            </div>
                            <div class="col mt-4" style="background-color: #ffc107">
                                <h5>Ghế Couple <br>(120.000 VNĐ)</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- THÔNG TIN PHIM -->
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-sm-5 mb-4 mb-sm-0">
                            <img src="<?php echo htmlspecialchars($movie_pic); ?>" class="w-100 img-movie img-fluid" alt="<?php echo htmlspecialchars($movie_title); ?>">
                        </div>
                        <div class="col-12 col-sm-7">
                            <div class="row">
                                <h1 class="text-center mb-4"><?php echo htmlspecialchars($movie_title); ?></h1>
                                <input type="hidden" name="movie_title" value="<?php echo htmlspecialchars($movie_title); ?>">
                                <table class="table table-borderless">
                                    <tr>
                                        <th><i class="bi bi-blockquote-left"></i>Chế độ</th>
                                        <td><?php echo htmlspecialchars($movie_type); ?></td>
                                        <input type="hidden" name="movie_type" value="<?php echo htmlspecialchars($movie_type); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-file-earmark-text"></i>Thể loại</th>
                                        <td><?php echo htmlspecialchars($movie_genra); ?></td>
                                        <input type="hidden" name="movie_genra" value="<?php echo htmlspecialchars($movie_genra); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-alarm"></i>Thời lượng</th>
                                        <td><?php echo htmlspecialchars($movie_duration); ?> phút</td>
                                        <input type="hidden" name="movie_duration" value="<?php echo htmlspecialchars($movie_duration); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-bank"></i>Rạp chiếu</th>
                                        <td><?php echo htmlspecialchars($cinema_name); ?></td>
                                        <input type="hidden" name="cinema_name" value="<?php echo htmlspecialchars($cinema_name); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-calendar-check"></i>Ngày chiếu</th>
                                        <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($show_date))); ?></td>
                                        <input type="hidden" name="show_date" value="<?php echo htmlspecialchars($show_date); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-alarm"></i>Giờ chiếu</th>
                                        <td><?php echo htmlspecialchars(date("H:i", strtotime($start_time))); ?></td>
                                        <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-tv"></i>Phòng chiếu</th>
                                        <td><?php echo htmlspecialchars($hall_name); ?></td>
                                        <input type="hidden" name="hall_name" value="<?php echo htmlspecialchars($hall_name); ?>">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-boxes"></i></i>Ghế ngồi</th>
                                        <td id="selected-seats"></td>
                                        <input type="hidden" id="selected-seats-input" name="selected_seats" value="">
                                    </tr>
                                    <tr>
                                        <th><i class="bi bi-coin"></i>Tổng giá</th>
                                        <td id="total-price">0 VNĐ</td>
                                        <input type="hidden" id="total-price-input" name="total_price" value="">
                                    </tr>
                                </table>
                                <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn btn-back col-12 w-100 mt-3" onclick="history.go(-1)">QUAY LẠI</a>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-next w-100 mt-3">
                                            TIẾP TỤC
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </form>
    </div>
</body>
<style>
    .img-movie{
        height: 100%;
        border-radius: 20px;
    }
</style>
</html>
