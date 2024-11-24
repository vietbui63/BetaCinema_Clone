<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ADD PAYMENT</title>
</head>
<body>
    
    <?php
        require 'config.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $paymentDate = mysqli_real_escape_string($connect, $_POST['PaymentDate']);
            $paymentMethod = mysqli_real_escape_string($connect, $_POST['PaymentMethod']);
            $userID = intval($_POST['UserID']);
            $movieTitle = mysqli_real_escape_string($connect, $_POST['MovieTitle']);
            $cinemaName = mysqli_real_escape_string($connect, $_POST['CinemaName']);
            $showDate = mysqli_real_escape_string($connect, $_POST['ShowDate']);
            $hallName = mysqli_real_escape_string($connect, $_POST['HallName']);
            $startTime = mysqli_real_escape_string($connect, $_POST['StartTime']);
            $seats = mysqli_real_escape_string($connect, $_POST['Seats']);
            $totalPrice = floatval($_POST['TotalPrice']); // Assuming total price is numeric

            $query = "INSERT INTO payments (`PaymentDate`, `PaymentMethod`, `UserID`, `MovieTitle`, `CinemaName`, `ShowDate`, `HallName`, `StartTime`, `Seats`, `TotalPrice`)
                    VALUES ('$paymentDate','$paymentMethod',$userID,'$movieTitle','$cinemaName','$showDate','$hallName','$startTime', '$seats', $totalPrice)";
            
            $result = mysqli_query($connect, $query);
            $payment = mysqli_fetch_assoc($result);

            if (mysqli_query($connect, $query)) {
                echo "<script>
                    alert('Payment đã được cập nhật.');
                    window.location.href = './payments.php';
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
        <h2 class="text-center mb-4">THÊM MỚI Payment</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="PaymentDate" class="form-label">Ngày Thanh Toán</label>
                        <input type="date" class="form-control" id="PaymentDate" name="PaymentDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="PaymentMethod" class="form-label">Phương Thức</label>
                        <select class="form-control" id="PaymentMethod" name="PaymentMethod" required>
                            <option value="" disabled selected>Chọn phương thức thanh toán</option>
                            <option value="Zalopay" <?php if (isset($payment['PaymentMethod']) && $payment['PaymentMethod'] == 'Zalopay') echo 'selected'; ?>>Zalopay</option>
                            <option value="Momo" <?php if (isset($payment['PaymentMethod']) && $payment['PaymentMethod'] == 'Momo') echo 'selected'; ?>>Momo</option>
                            <option value="Thanh toán tại Beta" <?php if (isset($payment['PaymentMethod']) && $payment['PaymentMethod'] == 'Thanh toán tại Beta') echo 'selected'; ?>>Thanh toán tại Beta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="UserID" class="form-label">ID User</label>
                        <select class="form-control" id="UserID" name="UserID" required>
                            <option value="" disabled selected>Chọn ID_User</option>
                            <?php
                            $userQuery = "SELECT UserID, Fullname FROM users";
                            $userResult = mysqli_query($connect, $userQuery);

                            if (mysqli_num_rows($userResult) > 0) {
                                while ($user = mysqli_fetch_assoc($userResult)) {
                                    $selected = ($user['UserID'] == $payment['UserID']) ? 'selected' : '';
                                    echo "<option value='" . $user['UserID'] . "' $selected>" . $user['UserID'] . " - " . $user['Fullname'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="MovieTitle" class="form-label">Tên Phim</label>
                        <select class="form-control" id="MovieTitle" name="MovieTitle" required>
                            <option value="" disabled selected>Chọn tên phim</option>
                            <?php
                            $movieQuery = "SELECT Title FROM movies";
                            $movieResult = mysqli_query($connect, $movieQuery);

                            if (mysqli_num_rows($movieResult) > 0) {
                                while ($movie = mysqli_fetch_assoc($movieResult)) {
                                    $selected = ($movie['Title'] == $payment['MovieTitle']) ? 'selected' : '';
                                    echo "<option value='" . $movie['Title'] . "' $selected>" . $movie['Title'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="CinemaName" class="form-label">Rạp Chiếu</label>
                        <select class="form-control" id="CinemaName" name="CinemaName" required>
                            <option value="" disabled selected>Chọn rạp chiếu</option>
                            <?php
                            $cinemaQuery = "SELECT CinemaName FROM cinemas";
                            $cinemaResult = mysqli_query($connect, $cinemaQuery);

                            if (mysqli_num_rows($cinemaResult) > 0) {
                                while ($cinema = mysqli_fetch_assoc($cinemaResult)) {
                                    $selected = ($cinema['CinemaName'] == $payment['CinemaName']) ? 'selected' : '';
                                    echo "<option value='" . $cinema['CinemaName'] . "' $selected>" . $cinema['CinemaName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ShowDate" class="form-label">Ngày Chiếu</label>
                        <input type="date" class="form-control" id="ShowDate" name="ShowDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="HallName" class="form-label">Phòng Chiếu</label>
                        <select class="form-control" id="HallName" name="HallName" required>
                            <option value="" disabled selected>Chọn phòng chiếu</option>
                            <option value="P1" <?php if (isset($payment['HallName']) && $payment['HallName'] == 'P1') echo 'selected'; ?>>P1</option>
                            <option value="P2" <?php if (isset($payment['HallName']) && $payment['HallName'] == 'P2') echo 'selected'; ?>>P2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="StartTime" class="form-label">Giờ Chiếu</label>
                        <input type="time" class="form-control" id="StartTime" name="StartTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="Seats" class="form-label">Ghế Ngồi</label>
                        <input type="text" class="form-control" id="Seats" name="Seats" required>
                    </div>
                    <div class="mb-3">
                        <label for="TotalPrice" class="form-label">Tổng Giá</label>
                        <input type="number" class="form-control" id="TotalPrice" name="TotalPrice" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="/BetaCinema_Clone/admin/pages/payments/payments.php" class="btn btn-outline-success">QUAY LẠI</a>
                <button type="submit" class="btn btn-success">THÊM</button>

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
