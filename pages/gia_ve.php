<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/rap.css'>

    <title>Giá vé</title>
</head>
<body>
    <div class="container mt-5">
        <?php
            require 'config.php';

            $cinema_id = isset($_GET['cinema_id']) ? $_GET['cinema_id'] : '';

            if ($cinema_id) {
                $query_cinema = "SELECT * FROM `cinemas` WHERE CinemaID = '$cinema_id'";
                $result_cinema = mysqli_query($connect, $query_cinema);

                $row_cinema = mysqli_fetch_assoc($result_cinema);
                $cinema_name = $row_cinema['CinemaName']; 
                $cinema_giave = $row_cinema['GiaVe']; 


                if (!$result_cinema) {
                    die("Query failed: " . mysqli_error($connect));
                }
            }
        ?>

        <h1 class="mb-5"><a href="/BetaCinema_Clone/pages/index.php"><i class="bi bi-arrow-left-short"></i></a>GIÁ VÉ RẠP <?php echo htmlspecialchars($cinema_name); ?></h1> 
        <div class="text-center mb-5">
            <img src="<?php echo htmlspecialchars($cinema_giave);?>" class="img-fluid" alt="">
        </div>

        <div class="text-center">
            <a href="/BetaCinema_Clone/pages/index.php" class="btn btn-back col-12 w-50 mb-5">
                QUAY LẠI
            </a>
        </div>
    </div>
</body>
<style>
    body {
        background-color: #e5e5e5; 
    }

    .img-fluid{
        border-radius: 20px;
        border: 1px solid #353535;
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
