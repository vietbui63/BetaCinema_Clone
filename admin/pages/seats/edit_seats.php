<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">

    <title>EDIT SEAT</title>
</head>
<body>
    <?php
        require 'config.php';

        if (!isset($_GET['id'])) {
            die("SeatID not provided.");
        }

        $id = intval($_GET['id']);
        $query = "SELECT * FROM seats WHERE SeatID = $id";
        $result = mysqli_query($connect, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            die("Seat not found.");
        }

        $seat = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $seatNumber = $_POST['seatNumber'];
            $vip = $_POST['vip'];
            $couple = $_POST['couple'];
            $hallID = intval($_POST['hallID']);

            $updateQuery = "UPDATE seats SET SeatNumber='$seatNumber', VIP='$vip', Couple='$couple', HallID=$hallID WHERE SeatID=$id";
            if (mysqli_query($connect, $updateQuery)) {
                header("Location: /BetaCinema_Clone/admin/pages/index.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($connect);
            }
        }
    ?>

    <div class="container w-50">
        <h2 class="text-center text-warning mb-4">CẬP NHẬT SEATS</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="seatNumber" class="form-label">Số Ghế</label>
                        <input type="text" class="form-control" id="seatNumber" name="seatNumber" 
                            value="<?= htmlspecialchars($seat['SeatNumber']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vip" class="form-label">VIP</label>
                        <select class="form-control" id="vip" name="vip" required>
                            <option value="0" <?= $seat['VIP'] == '0' ? 'selected' : '' ?>>Không</option>
                            <option value="1" <?= $seat['VIP'] == '1' ? 'selected' : '' ?>>Có</option>
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
                        <label for="couple" class="form-label">Couple</label>
                        <select class="form-control" id="couple" name="couple" required>
                            <option value="0" <?= $seat['Couple'] == '0' ? 'selected' : '' ?>>Không</option>
                            <option value="1" <?= $seat['Couple'] == '1' ? 'selected' : '' ?>>Có</option>
                        </select>
                    </div>
                </div>
                <div class="col text-center mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-warning" style="margin-right:15px">QUAY LẠI</a>
                    <button type="submit" class="btn btn-warning">CẬP NHẬT</button>
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
        border: 2px solid #ffc107;
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
