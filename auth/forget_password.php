<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/login_register.css">

    <title>Trang đăng nhập</title>
</head>
<script>
    /* REFRESH CAPTCHA */
    function refreshCaptcha() {
        event.preventDefault();
        document.getElementById('captcha-image').src = 'captcha.php?' + Math.random();
    }

    setTimeout(function() {
        var messageElement = document.getElementById("error");
        if (messageElement) {
            messageElement.style.display = "none";
        }
    }, 2000); 
</script>
<body>
    <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        session_start();
        require 'config.php';

        $error = '';
        $successMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy email từ form
            $email = htmlspecialchars($_POST['email']);
            
            // Kiểm tra email có tồn tại trong database
            $query = "SELECT UserID FROM users WHERE Email = '$email'";
            $result = mysqli_query($connect, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $userID = $row['UserID'];

                // Tạo mật khẩu ngẫu nhiên
                function generatePassword($length = 10) {
                    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    return substr(str_shuffle($chars), 0, $length);
                }
                $newPassword = generatePassword();

                // Hash mật khẩu
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Cập nhật mật khẩu trong database
                $updateQuery = "UPDATE users SET Pass_word = '$hashedPassword' WHERE UserID = '$userID'";
                if (!mysqli_query($connect, $updateQuery)) {
                    die("Không thể cập nhật mật khẩu: " . mysqli_error($connect));
                }

                // Gửi email với PHPMailer
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

                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('betacinema.clone@gmail.com', 'Beta Cinema Clone');
                    $mail->addAddress($email);

                    // Nội dung email
                    $mail->isHTML(true);
                    $mail->Subject = '[BetaCinemas] Khôi phục mật khẩu khách hàng';
                    $mail->Body    = "
                        <h2>Mật khẩu của bạn đã được đặt lại thành công!</h2>
                        <p>Mật khẩu mới của bạn: <strong>$newPassword</strong></p>
                        <p>Vui lòng đăng nhập và thay đổi mật khẩu ngay sau khi đăng nhập để đảm bảo an toàn.</p>
                    ";
                    $mail->AltBody = "Mật khẩu mới của bạn: $newPassword";

                    $mail->send();            
                    $successMessage = "
                        <div class='alert alert-success mt-4 p-1 text-center' style='color:green'>
                            <strong>Thành công!</strong> Mật khẩu mới đã được gửi qua email của bạn.
                            <a href='/BetaCinema_Clone/auth/login.php' class='btn btn-back mt-2'>
                                ĐĂNG NHẬP
                            </a>
                        </div>
                    "; 
                } catch (Exception $e) {
                    $error = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                }
            } else {
                $error = "Email không tồn tại trong hệ thống!";
            }
        }
    ?>

    <div class="container" style="max-width:500px">
        <form method="POST" action="">
            <a class="navbar-brand" href="/BetaCinema_Clone/pages/index.php"><img src="/BetaCinema_Clone/assets/logo.png" alt="Logo"></a>
            <div class="row">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <div class="input-group-text"><i class="bi bi-envelope-at-fill"></i></div>
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-7">
                    <img id="captcha-image" src="captcha.php" alt="Captcha Image">
                    <a href="" onclick="refreshCaptcha()"><i class="bi bi-arrow-repeat"></i></a>
                </div>
                <div class="col-5">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Mã xác thực" id="captcha" name="captcha" required>
                    </div>
                </div>
            </div>
            <div class="row mt-3">   
                <div class="col">
                    <a href="/BetaCinema_Clone/auth/login.php" class="btn btn-back col-12">
                        QUAY LẠI
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-submit col-12">LẤY LẠI MẬT KHẨU</button>
                </div>
            </div>
            
            <?php 
                if ($error) { echo "<div class='alert alert-danger mt-4 p-1 text-center' style='color:red; font-weight:bold'>$error</div>"; }              
                
                if ($successMessage) { 
                    echo $successMessage; 
                }
            ?>
            </form>
    </div>
</body>
<style>
    body { 
        font-size: 15px;
    }

    .btn{
        font-size: 15px;
    }
</style>
</html>