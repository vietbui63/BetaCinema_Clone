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
    <link rel='stylesheet' href="stylesLogin.css">

    <title>Trang đăng ký</title>
</head>
<body>
    <?php
        require 'config.php';

        $sql = "SHOW COLUMNS FROM `users` LIKE 'Sex'"; 
        $result = $connect->query($sql); 
        $row = $result->fetch_assoc(); 
        $type = $row['Type']; 
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches); 
        $enum_values = explode("','", $matches[1]);

        $mess = $error = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmpassword'];
            $dob = $_POST['dob'];
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];

            $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/"; 
            
            if (!preg_match($passwordPattern, $password)) {
                $error = 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và một ký tự đặc biệt.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $check_email = "SELECT Email FROM users WHERE Email = '$email'";
                $result = $connect->query($check_email);

                if ($result->num_rows > 0) {
                    $error = 'Email đã tồn tại. Vui lòng sử dụng email khác.';
                } else {
                    $sql = "INSERT INTO users (Fullname, Email, Pass_word, DoB, Sex, Phone) VALUES ('$fullname', '$email', '$hashedPassword', '$dob', '$sex', '$phone')";
                    if ($connect->query($sql) === TRUE) {
                        $mess = 'Đăng ký thành công';
                    } else {
                        echo "Lỗi: " . $sql . "<br>" . $connect->error;
                    }
                }
            }
            $connect->close();
        }
    ?>

    <div class="container">
        <form method="POST" action="">
            <a class="navbar-brand" href="/BetaCinema_Clone/home/index.php"><img src="/BetaCinema_Clone/assets/logo.png" alt="Logo"></a>
            <div class="row">
                <div class="col">
                    <span>*</span>
                    <label for="fullname" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" placeholder="Họ tên" id="fullname" name="fullname" required>
                </div>
                <div class="col">
                    <span>*</span>
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-envelope-at-fill"></i></div> 
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <span>*</span>
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-lock-fill"></i></div> 
                        <input type="password" class="form-control" placeholder="Mật khẩu" id="password" name="password" required>
                    </div> 
                </div>
                <div class="col">
                    <span>*</span>
                    <label for="confirmpassword" class="form-label">Xác nhận lại mật khẩu</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-lock-fill"></i></div> 
                        <input type="password" class="form-control" placeholder="Xác nhận lại mật khẩu" id="confirmpassword" name="confirmpassword" required>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <span>*</span>
                    <label for="dob" class="form-label">Ngày sinh</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-calendar-month"></i></div> 
                        <input type="date" class="form-control" placeholder="Ngày sinh" id="dob" name="dob" required>
                    </div> 
                </div>
                <div class="col">
                    <label for="sex" class="form-label">Giới tính</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-person-standing"></i></div> 
                        <select name="sex" id="sex" class="form-select">
                            <?php
                                foreach ($enum_values as $value){
                                    echo "<option value=\"$value\">$value</option>";
                                }
                            ?>
                        </select>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <span>*</span>
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <div class="input-group"> 
                        <div class="input-group-text"><i class="bi bi-telephone-fill"></i></div> 
                        <input type="text" class="form-control" placeholder="Số điện thoại" id="phone" name="phone" required>
                    </div> 
                </div>
                <div class="col">
                </div>
            </div>
            <div class="col mt-3">
                Bạn đã có tài khoản? <a href="/BetaCinema_Clone/auth/login.php">ĐĂNG NHẬP</a>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <img id="captcha-image" src="captcha.php" alt="Captcha Image">
                    <a href="" onclick="refreshCaptcha()"><i class="bi bi-arrow-repeat"></i></a>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Mã xác thực" id="captcha" name="captcha" required>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-submit col-12">ĐĂNG KÝ</button>
                </div>
                <div class="col">
                    <a href="/BetaCinema_Clone/home/index.php" class="btn btn-back col-12">QUAY LẠI</a>
                </div>
            </div>
            <?php if ($error) { echo "<div class='alert alert-danger mt-4 p-1 text-center' style='color:red; font-weight:bold'>$error</div>"; } ?>
            <?php if ($mess) { echo "<div class='alert alert-success mt-4 p-1 text-center' style='color:green; font-weight:bold'>$mess</div>"; } ?>
        </form>
    </div>
</body>
<style>
    .btn{
        font-size: 20px;
        text-align: center;
        transition: 0.5s;
        background-size: 200% auto;
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

    .btn:hover {
        background-position: right center; 
    }

    .btn-submit, .btn-submit:hover{
        background-image: linear-gradient(to right, #fc3606 0%, #fda085 51%, #fc7704 100%) !important;
    }

    .btn-back, .btn-back:hover{
        background-image: linear-gradient(to right, #0a64a7 0%, #258dcf 51%, #3db1f3 100%) !important;
    }
</style>
</html>
