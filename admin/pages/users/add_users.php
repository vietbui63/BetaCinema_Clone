<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">
    <title>ADD USERS</title>
</head>
<body>
    <?php
        require 'config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        // Mã hóa mật khẩu
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $dob = $_POST['dob'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];

        $query = "INSERT INTO users (Fullname, Email, Pass_word, Dob, Sex, Phone, Role) 
            VALUES ('$fullname', '$email', '$password', '$dob', '$sex', '$phone', '$role')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            header('Location: /BetaCinema_Clone/admin/pages/users/users.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }

    ?>

    <div class="container w-50">
        <h2 class="text-center text-success mb-4">THÊM MỚI USERS</h2>

        <form method="POST">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" 
                            title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và một ký tự đặc biệt">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sex" class="form-label">Giới tính</label>
                        <select class="form-control" id="sex" name="sex" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">SĐT</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
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
        background-color: #e5e5e5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .container{
        border: 2px solid #198754;
        border-radius: 20px;
        padding: 30px;
        background-color: #fff; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    }

    .form-control{
        border: 1px solid #111;
    }

    label{
        font-weight: bold;
    }
</style>
</html>
