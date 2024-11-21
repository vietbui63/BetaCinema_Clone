<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/thank.css'>
</head>
<body>
    <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

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

            $query = "INSERT INTO payments (PaymentMethod, UserID, MovieTitle, CinemaName, ShowDate, HallName, StartTime, Seats, TotalPrice) 
                            VALUES ('$payment_method', '$userID', '$movie_title', '$cinema_name', '$show_date', '$hall_name', '$start_time', '$selected_seats', '$total_price')";

            $result = mysqli_query($connect, $query);

            if (!$result) {
                die("Query failed: " . mysqli_error($connect));
            }

            require __DIR__ . '/../vendor/autoload.php';

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';  
                $mail->SMTPAuth   = true;
                $mail->Username   = 'betacinema.clone@gmail.com'; 
                $mail->Password   = 'hqvqbvtopyuebjby'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                
                $mail->setFrom('betacinema.clone@gmail.com', 'Beta Cinema Clone'); // Người gửi 
                $mail->addAddress($email); // Email người nhận (lấy từ session)

                $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '/BetaCinema_Clone/assets/logo.png', 'logo_cid');

                // Nội dung email
                $mail->isHTML(true);
                $mail->Subject = 'THANKS FOR ORDER!';
                $mail->Body    = '
                    <h2>Cảm ơn bạn đã đặt vé tại Beta Cinema!</h2>
                    <img src="cid:logo_cid" alt="Logo" style="width: 200px; height: auto;">
                    <p>Thông tin thanh toán của bạn:</p>
                    <ul>
                        <li><strong>Phim:</strong> ' . $movie_title . '</li>
                        <li><strong>Loại vé:</strong> ' . $movie_type . '</li>
                        <li><strong>Ngày chiếu:</strong> ' . date("d/m/Y", strtotime($show_date)) . '</li>
                        <li><strong>Giờ chiếu:</strong> ' . date("H:i", strtotime($start_time)) . '</li>
                        <li><strong>Phòng chiếu:</strong> ' . $hall_name . '</li>
                        <li><strong>Số ghế:</strong> ' . $selected_seats . '</li>
                        <li><strong>Tổng giá:</strong> ' . $total_price . ' VND</li>
                        <li><strong>Phương thức thanh toán:</strong> ' . $payment_method . '</li>
                    </ul>
                    <p>Chúc bạn xem phim vui vẻ!</p>
                ';
                $mail->AltBody = 'Cảm ơn bạn đã đặt vé tại Beta Cinema!';

                // Gửi email
                $mail->send();
            } catch (Exception $e) {
                echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
            }
        }
    ?>

    <div class="container mt-5 text-center">
        <img class="mb-5" src="/BetaCinema_Clone/assets/logo.png" alt="Logo">
        <h5 class="mb-5">CẢM ƠN BẠN ĐẶT VÉ</h5>
        <h5 class="mb-5">CHÚC BẠN CÓ NHỮNG PHÚT GIÂY VUI VẺ CÙNG BETA</h5>
        <h5 class="mb-5">THÔNG TIN VÉ ĐÃ ĐƯỢC GỬI VÀO EMAIL CỦA BẠN</h5>
        <a href="/BetaCinema_Clone/pages/index.php" class="btn col-12 w-50 mt-3">
            TRANG CHỦ
        </a>
    </div>
</body>
<style>
    .btn{
        font-size: 15px;
    }

    .container img{
        width: 250px;
        height: 80px;
    }
</style>
</html>