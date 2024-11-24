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
        require 'config.php';

        session_start();
        
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['refreshCaptcha'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $captcha = $_POST['captcha'];  // Mã CAPTCHA từ form
        
            // Kiểm tra mã CAPTCHA
            if ($captcha !== $_SESSION['captcha']) {
                $error = 'Mã CAPTCHA không đúng!';
            } else {
                // Xử lý đăng nhập
                $sql = "SELECT * FROM users WHERE Email='$email'";
                $result = mysqli_query($connect, $sql);
        
                if ($result && mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_assoc($result);
                    if (password_verify($password, $user['Pass_word'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['Fullname'] = $user['Fullname'];
                        $_SESSION['UserID'] = $user['UserID'];
                        $_SESSION['Email'] = $user['Email'];

                        if ($user['Role'] == 1) {
                            header("Location: /BetaCinema_Clone/pages/index.php");
                        } else if ($user['Role'] == 0) {
                            header("Location: /BetaCinema_Clone/admin/pages/index/index.php");
                        }

                        exit();
                    } else {
                        $error = 'Email hoặc mật khẩu không đúng!';
                    }
                } else {
                    $error = 'Email hoặc mật khẩu không đúng!';
                }
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
            <div class="row">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                    <input type="password" class="form-control" placeholder="Mật khẩu" id="password" name="password" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-7">
                    Bạn chưa có tài khoản? <a href="/BetaCinema_Clone/auth/register.php">ĐĂNG KÝ</a>
                </div>
                <div class="col-5 text-end">
                    <a href="/BetaCinema_Clone/auth/forget_password.php">Quên mật khẩu</a>
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
                    <a href="/BetaCinema_Clone/pages/index.php" class="btn btn-back col-12">
                        QUAY LẠI
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-submit col-12">ĐĂNG NHẬP</button>
                </div>
            </div>
            <?php if ($error) { echo "<div class='alert alert-danger mt-4 p-1 text-center' id='error' style='color:red; font-weight:bold'>$error</div>"; } ?>
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