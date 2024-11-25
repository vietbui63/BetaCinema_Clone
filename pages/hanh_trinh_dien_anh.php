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

    <div class="d-flex justify-content-center pt-5">
        <div class="container w-100">
            <ul class="nav nav-tabs justify-content-center" id="movieTabs" role="tablist">
                <li class="nav-item">
                    <a href="">THÔNG TIN</a>
                </li>
                <li class="nav-item">
                    <a href="hanh_trinh_dien_anh.php">HÀNH TRÌNH ĐIỆN ẢNH</a>
                </li>
            </ul>

            <div class="tab-content" id="movieTabContent">
                <!-- TAB LỊCH SỬ -->
                <div class="tab-pane fade w-100" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="row row-cols-1">
                        <?php
                            $query = "SELECT * FROM `payments` WHERE UserID = '$userID'";
                            $result = mysqli_query($connect, $query);

                            if (!$result) {
                                die("Query Failed: " . mysqli_error($connect));
                            }

                            /* PHÂN TRANG */
                            $rowsPerPage = 2;
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($currentPage - 1) * $rowsPerPage;

                            $countQuery = "SELECT COUNT(*) AS total FROM payments WHERE UserID = $userID";
                            $query = "SELECT * FROM payments LIMIT $offset, $rowsPerPage";

                            $countResult = mysqli_query($connect, $countQuery);
                            $totalRows = mysqli_fetch_assoc($countResult)['total'];
                            $result = mysqli_query($connect, $query);
                            $totalPages = ceil($totalRows / $rowsPerPage);

                            $stt = 1;

                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table table-bordered text-center">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>MÃ HOÁ ĐƠN</th>';
                                echo '<th>NGÀY ĐẶT</th>';
                                echo '<th>PHIM</th>';
                                echo '<th>RẠP CHIẾU</th>';
                                echo '<th>NGÀY CHIẾU</th>';
                                echo '<th>RẠP</th>';
                                echo '<th>SUẤT CHIẾU</th>';
                                echo '<th>GHẾ ĐÃ ĐẶT</th>';
                                echo '<th>PTTT</th>';
                                echo '<th>TỔNG GIÁ</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $formattedTotalPrice = number_format($row['TotalPrice'], 0, ',', '.');
                                    $formattedShowDate = date("d/m/Y", strtotime($row['ShowDate']));
                                    $formattedPaymentDate = date("d/m/Y", strtotime($row['PaymentDate']));
                                    $formattedStartTime = date("H:i", strtotime($row['StartTime']));
                                    echo '<tr>';
                                    echo '<td>' . $stt++ . '</td>';
                                    echo '<td>' . htmlspecialchars($formattedPaymentDate) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['MovieTitle']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['CinemaName']) . '</td>';
                                    echo '<td>' . htmlspecialchars($formattedShowDate) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['HallName']) . '</td>';
                                    echo '<td>' . htmlspecialchars($formattedStartTime) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['Seats']) . '</td>';
                                    echo '<td>' . htmlspecialchars(string: $row['PaymentMethod']) . '</td>';
                                    echo '<td>' . htmlspecialchars($formattedTotalPrice) . '</td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<h4 class="text-center" styles="color: red">Bạn chưa có hoá đơn nào</h4>';
                            }
                            mysqli_free_result($result);
                        ?>
                        <!-- PAGINATION -->
                        <div class="d-flex justify-content-center">
                            <ul class="pagination">
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?tab=history&page=<?= $currentPage - 1 ?>">&lt;</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="?tab=history&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?tab=history&page=<?= $currentPage + 1 ?>">&gt;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="col">
                            <a href="/BetaCinema_Clone/pages/index.php" class="btn btn-back col-12 w-100 mt-3">QUAY LẠI</a>
                        </div>
                    </div>
                </div>           
            </div>
        </div>
    </div>
</body>
<style>
    body { 
        font-size: 15px;
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