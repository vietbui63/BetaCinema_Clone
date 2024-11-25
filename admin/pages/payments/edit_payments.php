<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">

    <title>CẬP NHẬT PAYMENT</title>
</head>
<body>
    <?php
        require 'config.php';

        // Kiểm tra nếu ID thanh toán (Payment ID) không được cung cấp
        if (!isset($_GET['id'])) {
            die("Payment ID không được cung cấp.");
        }

        $paymentID = intval($_GET['id']);

        // Lấy dữ liệu thanh toán từ cơ sở dữ liệu
        $query = "SELECT * FROM payments WHERE PaymentID = $paymentID";
        $result = mysqli_query($connect, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            die("Thanh toán không tồn tại.");
        }

        $payment = mysqli_fetch_assoc($result);

        // Danh sách ghế và giá
        $seats = [
            "A1" => 45000, "A2" => 45000, "A3" => 45000, "A4" => 45000, "A5" => 45000,
            "B1" => 45000, "B2" => 45000, "B3" => 45000, "B4" => 45000, "B5" => 45000,
            "C1" => 70000, "C2" => 70000, "C3" => 70000, "C4" => 70000, "C5" => 70000,
            "D1" => 120000, "D2" => 120000, "D3" => 120000, "D4" => 120000, "D5" => 120000,
        ];

        // Tách ghế đã chọn từ cơ sở dữ liệu
        $selectedSeats = explode(", ", $payment['Seats']);

        // Tính tổng tiền từ ghế đã chọn
        $totalPrice = 0;
        foreach ($selectedSeats as $seat) {
            $totalPrice += isset($seats[$seat]) ? $seats[$seat] : 0;
        }

        // Xử lý form cập nhật
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $paymentDate = $_POST['PaymentDate'];
            $paymentMethod = $_POST['PaymentMethod'];
            $userID = $_POST['UserID'];
            $movieTitle = $_POST['MovieTitle'];
            $cinemaName = $_POST['CinemaName'];
            $showDate = $_POST['ShowDate'];
            $hallName = $_POST['HallName'];
            $startTime = $_POST['StartTime'];
            $seats = $_POST['Seats'];
            $totalPrice = $_POST['TotalPrice'];

            // Convert mảng ghế thành chuỗi
            $seatsString = implode(", ", $seats);

            // Loại bỏ ký tự không phải số từ tổng tiền
            $totalPriceNumeric = preg_replace('/[^0-9]/', '', $totalPrice);

            $updateQuery = "UPDATE payments 
                            SET `PaymentDate` = '$paymentDate', 
                                `PaymentMethod` = '$paymentMethod', 
                                `UserID` = $userID, 
                                `MovieTitle` = '$movieTitle', 
                                `CinemaName` = '$cinemaName', 
                                `ShowDate` = '$showDate', 
                                `HallName` = '$hallName', 
                                `StartTime` = '$startTime', 
                                `Seats` = '$seatsString', 
                                `TotalPrice` = $totalPriceNumeric 
                            WHERE PaymentID = $paymentID";

            if (mysqli_query($connect, $updateQuery)) {
                header("Location: /BetaCinema_Clone/admin/pages/payments/payments.php");
                exit;
            } else {
                echo "Cập nhật thất bại. Lỗi: " . mysqli_error($connect);
            }
        }
    ?>

    <div class="container w-50">
        <h2 class="text-center mb-4">CẬP NHẬT Payment</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="PaymentDate" class="form-label">Ngày Thanh Toán</label>
                        <input type="date" class="form-control" id="PaymentDate" name="PaymentDate" value="<?= htmlspecialchars($payment['PaymentDate']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="PaymentMethod" class="form-label">Phương Thức</label>
                        <select class="form-control" id="PaymentMethod" name="PaymentMethod" required>
                            <option value="Zalopay" <?php if ($payment['PaymentMethod'] == 'Zalopay') echo 'selected'; ?>>Zalopay</option>
                            <option value="Momo" <?php if ($payment['PaymentMethod'] == 'Momo') echo 'selected'; ?>>Momo</option>
                            <option value="Thanh toán tại Beta" <?php if ($payment['PaymentMethod'] == 'Thanh toán tại Beta') echo 'selected'; ?>>Thanh toán tại Beta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="UserID" class="form-label">ID User</label>
                        <select class="form-control" id="UserID" name="UserID" required>
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
                    <div class="mb-3">
                        <label for="ShowDate" class="form-label">Ngày Chiếu</label>
                        <input type="date" class="form-control" id="ShowDate" name="ShowDate" value="<?= htmlspecialchars($payment['ShowDate']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="HallName" class="form-label">Phòng Chiếu</label>
                        <select class="form-control" id="HallName" name="HallName" required>
                            <option value="P1" <?php if ($payment['HallName'] == 'P1') echo 'selected'; ?>>P1</option>
                            <option value="P2" <?php if ($payment['HallName'] == 'P2') echo 'selected'; ?>>P2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="StartTime" class="form-label">Giờ Chiếu</label>
                        <input type="time" class="form-control" id="StartTime" name="StartTime" value="<?= htmlspecialchars($payment['StartTime']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Seats" class="form-label">Chọn Ghế Ngồi</label>
                        <div class="seat-selection">
                            <?php foreach ($seats as $seat => $price): ?>
                                <?php
                                    $isChecked = in_array($seat, $selectedSeats) ? 'checked' : '';
                                    $divClass = $isChecked ? 'seat-option checked' : 'seat-option';
                                ?>
                                <div class="<?= $divClass ?>">
                                    <input type="checkbox" name="Seats[]" value="<?= $seat ?>"
                                        <?= $isChecked ?> id="seat_<?= $seat ?>" onchange="updateTotal()">
                                    <label class="form-check-label" for="seat_<?= $seat ?>">
                                        <?= $seat ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="TotalPrice" class="form-label">Tổng Tiền</label>
                        <input type="text" class="form-control" id="TotalPrice" name="TotalPrice" value="<?= number_format($totalPrice) ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <a href="javascript:history.back()" class="btn btn-outline-warning" style="margin-right:15px">QUAY LẠI</a>
                <button type="submit" class="btn btn-warning">CẬP NHẬT</button>
            </div>
        </form>
    </div>
    <script>
        document.querySelectorAll('input[name="Seats[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const maxSeats = 5;
                let selected = document.querySelectorAll('input[name="Seats[]"]:checked');

                // Kiểm tra giới hạn ghế được chọn
                if (selected.length > maxSeats) {
                    alert(`Bạn chỉ được chọn tối đa ${maxSeats} ghế.`);
                    this.checked = false;
                    return;
                }

                // Tính tổng tiền
                let total = 0;
                selected.forEach(function(cb) {
                    const seat = cb.value;
                    const price = <?= json_encode($seats) ?>[seat];
                    total += price;
                });
                document.getElementById('TotalPrice').value = total.toLocaleString();
            });
        });
    </script>
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
            border: 2px solid #ffc107;
            border-radius: 20px;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #ffc107;
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(0, 123, 255, 0.2);
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
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

        .seat-selection {
            display: grid;
            height: 233px;
            grid-template-columns: repeat(5, 1fr);
            align-items: stretch;
            gap: 10px;
            box-sizing: border-box;
        }

        .seat-option {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            overflow: hidden;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            border: solid 1px #111;
        }

        .seat-option input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
            margin: 0;
            cursor: pointer;
        }

        .seat-option .form-check-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: bold;
            background-color: white;
            color: black;
            z-index: 1;
            box-sizing: border-box;
        }

        .seat-option input[type="checkbox"]:checked + .form-check-label {
            background-color: #4CAF50;
            color: white;
            outline: 2px solid #4CAF50;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }
    </style>
</html>
