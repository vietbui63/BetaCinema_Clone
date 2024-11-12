<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn lịch chiếu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">LỊCH CHIẾU></h2>
        <?php
            require 'config.php';

            $cinema_id = isset($_GET['cinema_id']) ? $_GET['cinema_id'] : '';
            $movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : '';

            if ($cinema_id && $movie_id) {
                $query = "SELECT ShowtimeID, ShowDate, StartTime FROM `show_times` WHERE MovieID = '$movie_id' AND HallID = '$cinema_id' ORDER BY ShowDate, StartTime";
                $result = mysqli_query($connect, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($connect));
                }
            }
        ?>

        <form action="chon_ghe.php" method="post" class="shadow p-4 rounded bg-white">
            <input type="hidden" name="cinema_id" value="<?php echo htmlspecialchars($cinema_id); ?>">
            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie_id); ?>">

            <div class="mb-3">
                <label for="showdate" class="form-label">Choose a date:</label>
                <select name="showdate" id="showdate" class="form-select" required>
                    <option value="">Select Show Date</option>
                    <?php
                    $dates = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $showDate = $row['ShowDate'];
                        if (!in_array($showDate, $dates)) {
                            $dates[] = $showDate;
                            echo '<option value="' . htmlspecialchars($showDate) . '">' . htmlspecialchars($showDate) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="starttime" class="form-label">Choose a time:</label>
                <select name="starttime" id="starttime" class="form-select" required>
                    <option value="">Select Start Time</option>
                    <?php
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['StartTime']) . '" data-showdate="' . htmlspecialchars($row['ShowDate']) . '">' . htmlspecialchars($row['StartTime']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Proceed to Book Seats</button>
        </form>
        <a href="/BetaCinema_Clone/home/index.php" class="btn btn-back col-12">
                        QUAY LẠI
                    </a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.getElementById('showdate').addEventListener('change', function () {
        var selectedDate = this.value;
        var timeOptions = document.getElementById('starttime').options;

        // Show only times that match the selected date
        for (var i = 0; i < timeOptions.length; i++) {
            var option = timeOptions[i];
            option.style.display = option.getAttribute('data-showdate') === selectedDate ? 'block' : 'none';
        }
        document.getElementById('starttime').value = ""; 
    });

    // Trigger initial filtering when the page loads
    document.getElementById('showdate').dispatchEvent(new Event('change'));
    </script>
</body>
</html>
