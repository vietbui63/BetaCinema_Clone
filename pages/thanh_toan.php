<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='/BetaCinema_Clone/styles/thanh_toan.css'>
</head>
<body>
    <?php
        require 'config.php';

        $movie_title = htmlspecialchars($_POST['movie_title']);
        $movie_type = htmlspecialchars($_POST['movie_type']);
        $movie_genra = htmlspecialchars($_POST['movie_genra']);
        $movie_duration = htmlspecialchars($_POST['movie_duration']);
        $cinema_name = htmlspecialchars($_POST['cinema_name']);
        $show_date = htmlspecialchars($_POST['show_date']);
        $start_time = htmlspecialchars($_POST['start_time']);
        $hall_name = htmlspecialchars($_POST['hall_name']);
        $selected_seats = htmlspecialchars($_POST['selected_seats']);
        $total_price = htmlspecialchars($_POST['total_price']);   
    ?>
    
    <div class="container mt-5">
        <h2 class="text-center mb-5">THANH TOÁN</h2>
        <form action="/BetaCinema_Clone/pages/thank.php" method="post" onsubmit="return validatePaymentMethod()">
            <div class="row">
                <!-- Movie Information -->
                <div class="col-12 col-lg-6 mb-4">
                    <table class="table table-borderless">
                        <tr>
                            <th>Tên phim</th>
                            <td><?php echo $movie_title; ?></td>
                            <input type="hidden" name="movie_title" value="<?php echo $movie_title; ?>">
                        </tr>
                        <tr>
                            <th>Chế độ</th>
                            <td><?php echo $movie_type; ?></td>
                            <input type="hidden" name="movie_type" value="<?php echo $movie_type; ?>">
                        </tr>
                        <tr>
                            <th>Thể loại</th>
                            <td><?php echo $movie_genra; ?></td>
                            <input type="hidden" name="movie_genra" value="<?php echo $movie_genra; ?>">
                        </tr>
                        <tr>
                            <th>Thời lượng</th>
                            <td><?php echo $movie_duration; ?> phút</td>
                            <input type="hidden" name="movie_genra" value="<?php echo $movie_genra; ?>">
                        </tr>
                        <tr>
                            <th>Rạp chiếu</th>
                            <td><?php echo $cinema_name; ?></td>
                            <input type="hidden" name="cinema_name" value="<?php echo $cinema_name; ?>">
                        </tr>
                        <tr>
                            <th>Ngày chiếu</th>
                            <td><?php echo date("d/m/Y", strtotime($show_date)); ?></td>
                            <input type="hidden" name="show_date" value="<?php echo $show_date; ?>">
                        </tr>
                        <tr>
                            <th>Giờ chiếu</th>
                            <td><?php echo date("H:i", strtotime($start_time)); ?></td>
                            <input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
                        </tr>
                        <tr>
                            <th>Phòng chiếu</th>
                            <td><?php echo $hall_name; ?></td>
                            <input type="hidden" name="hall_name" value="<?php echo $hall_name; ?>">
                        </tr>
                        <tr>
                            <th>Ghế ngồi</th>
                            <td><?php echo $selected_seats; ?></td>
                            <input type="hidden" name="selected_seats" value="<?php echo $selected_seats; ?>">
                        </tr>
                        <tr>
                            <th>Tổng giá</th>
                            <td><?php echo $total_price; ?></td>
                            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                        </tr>
                    </table>
                </div>
                
                <!-- Payment Method Selection -->
                <div class="col-12 col-lg-6">
                    <div class="row mb-4 text-center mt-5">
                        <h5 class="mb-5">CHỌN PHƯƠNG THỨC THANH TOÁN</h5>
                        <div class="col-4">
                            <input type="radio" class="form-check-input" id="zalopay" name="payment_method" value="Zalopay">
                            <label class="form-check-label" for="zalopay">
                                <img src="/BetaCinema_Clone/assets/zalopay.png" alt="Zalopay" class="img-fluid">
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="radio" class="form-check-input" id="momo" name="payment_method" value="Momo">
                            <label class="form-check-label" for="momo">
                                <img src="/BetaCinema_Clone/assets/momo.png" alt="Momo" class="img-fluid">
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="radio" class="form-check-input" id="cod" name="payment_method" value="Thanh toán tại Beta">
                            <label class="form-check-label" for="cod">
                                <img src="/BetaCinema_Clone/assets/cart.png" alt="Thanh toán tại Beta" class="img-fluid mb-3">
                                <span>Thanh toán tại Beta</span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-back col-12 w-100 mt-3" onclick="history.go(-1)">QUAY LẠI</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-next w-100 mt-3">
                                THỰC HIỆN
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validatePaymentMethod() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert("Vui lòng chọn phương thức thanh toán");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
