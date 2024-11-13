<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Chọn lịch chiếu</title>
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
        <form action="chon_ghe.php" method="post" class="p-4">
            <input type="hidden" name="cinema_id" value="<?php echo htmlspecialchars($cinema_id); ?>">
            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">

            <h2 class="text-center mb-4">LỊCH CHIẾU - <?php echo htmlspecialchars($movie_title); ?></h2> 
            <h3 class="text-center mb-5">Rạp <?php echo htmlspecialchars(string: $cinema_name); ?></h3> 

            <div class="mb-4">
                <select name="showdate" id="showdate" class="form-select" required>
                    <option value="">Chọn ngày</option>
                    <?php
                        $query = "SELECT ShowDate, StartTime FROM `show_times` WHERE MovieID = '$movie_id' ORDER BY ShowDate, StartTime";
                        $result = mysqli_query($connect, $query);

                        if (!$result) {
                            die("Query failed: " . mysqli_error($connect));
                        }

                        $dates = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                            $showDate = $row['ShowDate'];
                            $formattedDate = date("d/m/Y", strtotime($showDate));
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
                            echo '<option value="' . htmlspecialchars($startTime) . '" data-showdate="' . htmlspecialchars($row['ShowDate']) . '">' . htmlspecialchars($formattedTime) . '</option>';
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-50 mt-3">
                ĐỒNG Ý
            </button>

            <a href="/BetaCinema_Clone/home/index.php" class="btn btn-back col-12 w-50 mt-3">
                QUAY LẠI
            </a>
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
    body {
        background-image: url('/BetaCinema_Clone/assets/bg-lich-chieu.png'); 
        background-position: center; 
        background-size: cover;
        background-repeat: no-repeat;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100vh;
    }

    .container {
        background: rgba(255, 255, 255, 0.5); 
        backdrop-filter: blur(20px); 
        text-align: center;
        width: 90%; 
        max-width: 600px; 
        margin: auto;
        padding: 20px;
        border-radius: 20px; 
    }

    .mb-4{
        display: flex;
        justify-content: center;
    }

    .mb-4 select{
        font-weight: bold;
        font-size: 20px;
        border: 2px solid #ced4da;
    }
    
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
        background-image: linear-gradient(to right, #0a64a7 0%, #258dcf 51%, #3db1f3 100%) !important;
        color: #fff;
        border: none;
    }

    .btn:hover {
        background-position: right center; 
    }

    .btn-back, .btn-back:hover{
        background-image: linear-gradient(to right, #fc3606 0%, #fda085 51%, #fc7704 100%) !important;
    }
</style>
</html>
