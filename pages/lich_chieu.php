<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn lịch chiếu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/lich_chieu.css'>
</head>
<body>
    <?php
        require 'config.php';

        $cinema_id = isset($_GET['cinema_id']) ? $_GET['cinema_id'] : '';
        $movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : '';

        if ($cinema_id && $movie_id) {
            $query_title = "SELECT Title FROM `movies` WHERE MoviesID = '$movie_id'";
            $result_title = mysqli_query($connect, $query_title);

            if (!$result_title) {
                die("Query failed: " . mysqli_error($connect));
            }

            $row_title = mysqli_fetch_assoc($result_title);
            $movie_title = $row_title['Title']; 

            $query_cinema = "SELECT CinemaName FROM `cinemas` WHERE CinemaID = '$cinema_id'";
            $result_cinema = mysqli_query($connect, $query_cinema);

            $row_cinema = mysqli_fetch_assoc($result_cinema);
            $cinema_name = $row_cinema['CinemaName']; 

            if (!$result_cinema) {
                die("Query failed: " . mysqli_error($connect));
            }
        }
    ?>
    <div class="container">     
        <form action="/BetaCinema_Clone/pages/chon_ghe.php" method="post" class="p-4">
            <input type="hidden" name="cinema_id" value="<?php echo htmlspecialchars($cinema_id); ?>">
            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">

            <h2 class="text-center mb-4">LỊCH CHIẾU - <?php echo htmlspecialchars($movie_title); ?></h2> 
            <h3 class="text-center mb-5">Rạp <?php echo htmlspecialchars($cinema_name); ?></h3> 

            <div class="mb-4">
                <select name="showdate" id="showdate" class="form-select" required>
                    <option value="">Chọn ngày</option>
                    <?php
                        $query = "SELECT ShowDate, StartTime, HallID FROM `show_times` WHERE MovieID = '$movie_id' ORDER BY ShowDate, StartTime";
                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            die("Query failed: " . mysqli_error($connect));
                        }

                        $dates = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                            $showDate = $row['ShowDate'];
                            $formattedDate = date("d/m/Y - l", strtotime($showDate));
                            if (!in_array($showDate, $dates)) {
                                $dates[] = $showDate;
                                echo '<option value="' . htmlspecialchars($showDate) . '">' . htmlspecialchars($formattedDate) . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <select name="starttime" id="starttime" class="form-select" required>
                    <option value="">Chọn xuất chiếu</option>
                    <?php
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $startTime = $row['StartTime'];
                            $formattedTime = date("H:i", strtotime($startTime));
                            echo '<option value="' . htmlspecialchars($startTime) . '" data-showdate="' . htmlspecialchars($row['ShowDate']) . '">' . htmlspecialchars($formattedTime) . ' - Hall ' . htmlspecialchars($row['HallID']) . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="row">
                <div class="col">
                    <a href="/BetaCinema_Clone/pages/index.php" class="btn btn-back col-12 w-100 mt-3">
                        QUAY LẠI
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100 mt-3">
                        ĐỒNG Ý
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('showdate').addEventListener('change', function () {
            var selectedDate = this.value;
            var timeOptions = document.getElementById('starttime').options;

            for (var i = 0; i < timeOptions.length; i++) {
                var option = timeOptions[i];
                option.style.display = option.getAttribute('data-showdate') === selectedDate ? 'block' : 'none';
            }
            document.getElementById('starttime').value = ""; 
        });

        document.getElementById('showdate').dispatchEvent(new Event('change'));
    </script>
</body>
<style>
    .btn{
        font-size: 20px;
        text-align: center;
        transition: 0.5s;
        background-size: 200% auto;
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

    .btn, .btn:hover{
        background-image: linear-gradient(to right, #fc3606 0%, #fda085 51%, #fc7704 100%) !important;
        color: #fff;
        border: none;
    }

    .btn:hover {
        background-position: right center; 
    }

    .btn-back, .btn-back:hover{
        background-image: linear-gradient(to right, #0a64a7 0%, #258dcf 51%, #3db1f3 100%) !important;
    }
</style>
</html>
