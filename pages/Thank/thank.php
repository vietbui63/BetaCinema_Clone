<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='thank.css'>
</head>
<body>
    <?php
        session_start();
        require 'config.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payment_method = htmlspecialchars($_POST['payment_method']);
            $userID = $_SESSION['UserID'];
            $email = $_SESSION['Email'];
            $movie_title = htmlspecialchars($_POST['movie_title']);
            $movie_type = htmlspecialchars($_POST['movie_type']);
            $movie_genra = htmlspecialchars($_POST['movie_genra']);
            $cinema_name = htmlspecialchars($_POST['cinema_name']);
            $show_date = htmlspecialchars($_POST['show_date']);
            $start_time = htmlspecialchars($_POST['start_time']);
            $hall_name = htmlspecialchars($_POST['hall_name']);
            $selected_seats = htmlspecialchars($_POST['selected_seats']);
            $total_price = htmlspecialchars($_POST['total_price']);

            $query = "INSERT INTO `payments` (`PaymentMethod`, `UserID`, `MovieTitle`, `CinemaName`, `ShowDate`, `HallName`, `StartTime`, `Seats`, `TotalPrice`) 
                    VALUES ('$payment_method', '$userID', '$movie_title', '$cinema_name', '$show_date', '$hall_name', '$start_time', '$selected_seats', '$total_price')";

            $result = mysqli_query($connect, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($connect));
            }
        } else {
            echo "Invalid form submission.";
        }
    ?>

    <div class="container mt-5 text-center">
        <img class="mb-5" src="/BetaCinema_Clone/assets/logo.png" alt="Logo">
        <h2 class="mb-5">CẢM ƠN BẠN ĐẶT VÉ</h2>
        <h2 class="mb-5">CHÚC BẠN CÓ NHỮNG PHÚT GIÂY VUI VẺ CÙNG BETA</h2>
        <a href="/BetaCinema_Clone/pages/Home/index.php" class="btn col-12 w-50 mt-3">
            TRANG CHỦ
        </a>
    </div>
</body>