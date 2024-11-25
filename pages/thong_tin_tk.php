<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/home.css'>
    <!-- CSS -->
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/thanh_vien.css'>

    <title>Thông tin tài khoản</title>
</head>
<script>
    setTimeout(function() {
        var messageElement = document.getElementById("mess");
        if (messageElement) {
            messageElement.style.display = "none";
        }
    }, 2000); 

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

        $userID = $_SESSION['UserID'] ?? null;

        $query = "SELECT Fullname, Email, Dob, Sex, Phone, Pass_word FROM users WHERE UserID = '$userID'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
        } else {
            echo "Could not retrieve user information.";
        }

        $mess = '';
        $error = ''; 

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];

            $currentPassword = $_POST['current_password'] ?? null;
            $newPassword = $_POST['new_password'] ?? null;
            $confirmPassword = $_POST['confirm_password'] ?? null;

            $updateQuery = "UPDATE users SET Fullname = '$fullname', Email = '$email', Dob = '$dob', Sex = '$sex', Phone = '$phone' WHERE UserID = '$userID'";

            if ($currentPassword && $newPassword && $confirmPassword) {
                if (password_verify($currentPassword, $user['Pass_word'])) {
                    if ($newPassword === $confirmPassword) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $updateQuery = "UPDATE users SET Fullname = '$fullname', Email = '$email', Dob = '$dob', Sex = '$sex', Phone = '$phone', Pass_word = '$hashedPassword' WHERE UserID = '$userID'";
                    } else {
                        $error = "Mật khẩu mới và mật khẩu xác nhận không khớp."; 
                    }
                } else {
                    $error = "Mật khẩu hiện tại không đúng."; 
                }
            }

            if (!$error) {
                $updateResult = mysqli_query($connect, $updateQuery);
    
                if ($updateResult) {
                    $mess = "Cập nhật thành công!";
                    // Refresh user info
                    $user = mysqli_fetch_assoc(mysqli_query($connect, $query));
                } else {
                    $error = "Lỗi cập nhật: " . mysqli_error($connect);
                }
            }
        }
    ?>

    <div class="container">
        <h3 class="text-center mb-5">THÔNG TIN TÀI KHOẢN</h3>
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <?php if (isset($user)) { ?>
            <form method="POST" action="">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <span>*</span>
                            <label for="fullname" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['Fullname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <span>*</span>
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label">Giới tính</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="Nam" <?php if ($user['Sex'] == 'Nam') echo 'selected'; ?>>Nam</option>
                                <option value="Nữ" <?php if ($user['Sex'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                                <option value="Khác" <?php if ($user['Sex'] == 'Khác') echo 'selected'; ?>>Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <span>*</span>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <span>*</span>
                            <label for="dob" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($user['Dob']); ?>" required>
                        </div>
                        <!-- Mật khẩu hiện tại -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        <!-- Mật khẩu mới -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và một ký tự đặc biệt">
                        </div>
                        <!-- Xác nhận mật khẩu mới -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <a href="/BetaCinema_Clone/pages/index.php" class="btn btn-back col-12 w-100 mt-3">QUAY LẠI</a>
                    </div>
                    <div class="col">
                        <button type="submit" name="update_profile" class="btn btn-next w-100 mt-3">
                            CẬP NHẬT
                        </button>
                    </div>
                </div>
                <?php if ($mess) { echo "<div class='alert alert-success mt-4 p-1 text-center' id='mess' style='color:green; font-weight:bold'>$mess</div>"; } ?>
                <?php if ($error) { echo "<div class='alert alert-danger mt-4 p-1 text-center' id='error' style='color:red; font-weight:bold'>$error</div>"; } ?>
            </form>
            <?php } else { ?>
            <p>Không thể lấy thông tin người dùng.</p>
            <?php } ?>
        </div>
    </div>
</body>
<style>
    body { 
        font-size: 15px;
    }

    .container{
        width: 100%;
    }

    .form-control{
        font-size: 15px;
    }

    .nav-tabs .nav-link {
        font-weight: bold;
        color: #333;
        font-size: 20px;
    }

    .btn-next, .btn-back{
        font-size: 15px;
    }

    .table{
        border-radius: 20px;
    }

    .table th, .table td {
        background: none; 
        font-size: 18px;
    }
</style>
</html>