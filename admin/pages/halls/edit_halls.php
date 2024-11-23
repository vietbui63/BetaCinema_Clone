<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">

    <title>EDIT HALL</title>
</head>
<body>
    <?php
        require 'config.php';

        if (!isset($_GET['id'])) {
            die("HallID not provided.");
        }

        $id = intval($_GET['id']);

        $query = "SELECT * FROM halls WHERE HallID = $id";
        $result = mysqli_query($connect, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            die("Hall not found.");
        }

        $hall = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hallname = $_POST['hallname'];
            $seatcount = $_POST['seatcount'];
            $cinemaid = $_POST['cinemaid'];

            $updateQuery = "UPDATE halls 
                                    SET HallName='$hallname', SeatCount='$seatcount', CinemaID='$cinemaid' 
                                    WHERE HallID=$id";

            if (mysqli_query($connect, $updateQuery)) {
                header("Location: /BetaCinema_Clone/admin/pages/index.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($connect);
            }
        }
    ?>

    <div class="container w-50">
        <h2 class="text-center text-warning mb-4">CẬP NHẬT HALLS</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="hallname" class="form-label">Tên Hall</label>
                        <input type="text" class="form-control" id="hallname" name="hallname"
                            value="<?= htmlspecialchars($hall['HallName']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="seatcount" class="form-label">Số ghế</label>
                        <input type="number" class="form-control" id="seatcount" name="seatcount"
                            value="<?= htmlspecialchars($hall['SeatCount']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="cinemaid" class="form-label">Cinema ID</label>
                        <input type="number" class="form-control" id="cinemaid" name="cinemaid"
                            value="<?= htmlspecialchars($hall['CinemaID']) ?>" required>
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
        background-color: #e5e5e5;
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
</style>
</html>
