<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ADD SEAT</title>
</head>
<body>
<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seatNumber = $_POST['seatNumber'];
    $vip = $_POST['vip'];
    $couple = $_POST['couple'];
    $hallID = intval($_POST['hallID']);

    $query = "INSERT INTO seats (SeatNumber, VIP, Couple, HallID) VALUES ('$seatNumber', '$vip', '$couple', $hallID)";
    if (mysqli_query($connect, $query)) {
        header("Location: /BetaCinema_Clone/admin/pages/index.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($connect);
    }
}
?>

<div class="container w-50">
    <h2 class="text-center text-success mb-4">THÊM MỚI SEAT</h2>

    <form method="POST">
        <div class="row mt-5">
            <div class="col">
                <div class="mb-3">
                    <label for="seatNumber" class="form-label">Seat Number</label>
                    <input type="text" class="form-control" id="seatNumber" name="seatNumber" required>
                </div>
                <div class="mb-3">
                    <label for="seatType" class="form-label">Seat Type</label>
                    <select class="form-select" id="seatType" name="seatType" required>
                        <option value="vip">VIP</option>
                        <option value="couple">Couple</option>
                        <option value="normal">Bình Thường</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="hallID" class="form-label">Hall ID</label>
                    <input type="text" class="form-control" id="hallID" name="hallID" required>
                </div>
            </div>
            <div class="row text-center">
                <button type="submit" class="btn btn-success mt-4">THÊM</button>
                <a href="/BetaCinema_Clone/admin/pages/index.php" class="btn btn-outline-success mt-3">QUAY
                    LẠI</a>
            </div>
        </div>
    </form>
</div>
</body>
<style>
    body {
        background-color: #e5e5e5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        border: 2px solid #198754;
        border-radius: 20px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border: 1px solid #111;
    }

    label {
        font-weight: bold;
    }

    .d-flex {
        display: flex;
    }

    .gap-3 {
        gap: 1rem;
    }
</style>
</html>
