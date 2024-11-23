<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">

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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="seatNumber" class="form-label">Số ghế</label>
                        <input type="text" class="form-control" id="seatNumber" name="seatNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="VIP" class="form-label">VIP</label>
                        <select class="form-select" id="VIP" name="VIP" required>
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="hallID" class="form-label">ID Phòng</label>
                        <select class="form-control" name="hallID" id="hallID">
                            <?php
                                $query = "SELECT HallID, HallName  FROM `halls`";
                                $result = mysqli_query($connect, $query);

                                if(!$result)
                                    die("Query failed!" . mysqli_connect_error());

                                if(mysqli_num_rows($result) != 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $str = "<option value='" . $row['HallID'] . "'>" . $row['HallName'] . "</option>";
                                        echo $str;
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Couple" class="form-label">Couple</label>
                        <select class="form-select" id="Couple" name="Couple" required>
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                </div>
                <div class="col text-center mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-success" style="margin-right:15px">QUAY LẠI</a>
                    <button type="submit" class="btn btn-success">THÊM</button>
                </div>
            </div>
        </form>
    </div>
</body>
<style>
    body {
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
</style>
</html>
