<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>THÊM SHOWTIMES</title>
    
</head>
<body>
    <?php
        require 'config.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movieID = $_POST['MovieID'];
            $showDate = $_POST['ShowDate'];
            $hallID = $_POST['HallID'];
            $startTime = $_POST['StartTime'];
            $endTime = $_POST['EndTime'];

            $query = "INSERT INTO show_times (`MovieID`, `ShowDate`, `HallID`, `StartTime`, `EndTime`)
                    VALUES ('$movieID','$showDate','$hallID','$startTime', '$endTime')";
            $result = mysqli_query($connect, $query);
            
            if ($result) {
                echo "<script>
                    alert('Showtime đã được thêm thành công.');
                    window.location.href = '/BetaCinema_Clone/admin/pages/index.php';
                </script>";
                exit();
            } else {
                echo "<script>
                    alert('Error: " . mysqli_real_escape_string($connect, mysqli_error($connect)) . "');
                    window.history.back();
                </script>";
            }            
        }
    ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">THÊM MỚI SHOWTIMES</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="MovieID" class="form-label">Tên phim</label>
                        <select class="form-control" id="MovieID" name="MovieID" required>
                            <?php
                                $movieQuery = "SELECT MoviesID, Title FROM movies"; 
                                $movieResult = mysqli_query($connect, $movieQuery);
                                
                                if (mysqli_num_rows($movieResult) > 0) {
                                    while ($movie = mysqli_fetch_assoc($movieResult)) {
                                        echo "<option value='" . $movie['MoviesID'] . "'>" . $movie['Title'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ShowDate" class="form-label">Ngày chiếu</label>
                        <input type="date" class="form-control" id="ShowDate" name="ShowDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="HallID" class="form-label">Phòng chiếu</label>
                        <select class="form-control" id="HallID" name="HallID" required>
                            <?php
                                $hallQuery = "SELECT HallID, HallName FROM halls WHERE HallName IN ('P1', 'P2')";
                                $hallResult = mysqli_query($connect, $hallQuery);

                                $shownHalls = [];

                                if (mysqli_num_rows($hallResult) > 0) {
                                    while ($hall = mysqli_fetch_assoc($hallResult)) {
                                        if (!in_array($hall['HallName'], $shownHalls)) {
                                            $shownHalls[] = $hall['HallName'];
                                            $selected = ($hall['HallID'] == $showtime['HallID']) ? 'selected' : '';
                                            echo "<option value='" . $hall['HallID'] . "' $selected>" . $hall['HallName'] . "</option>";
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="StartTime" class="form-label">Giờ chiếu</label>
                        <input type="time" class="form-control" id="StartTime" name="StartTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="EndTime" class="form-label">Giờ kết thúc</label>
                        <input type="time" class="form-control" id="EndTime" name="EndTime" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">THÊM</button>
                <a href="/BetaCinema_Clone/admin/pages/index.php" class="btn btn-outline-success">QUAY LẠI</a>
            </div>
        </form>
    </div>
</body>
<style>
    body{
        background-color: #e5e5e5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container{
        border: 2px solid #198754;
        border-radius: 20px;
        padding: 30px;
        background-color: #fff; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    }

    h2 {
        color: #198754;
        font-weight: bold;
        text-transform: uppercase;
        text-shadow: 1px 1px 3px rgba(0, 123, 255, 0.2);
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        font-size: 1rem;
    }

    .form-control {
        border: 1px solid #111;
        border-radius: 8px;
        padding: 10px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #66afe9;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }

    .btn-success {
        border-radius: 25px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-success:hover {
        transform: scale(1.05);
    }

    .btn-outline-success {
        border-radius: 25px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-outline-success:hover {
        transform: scale(1.05);
    }
</style>
</html>
