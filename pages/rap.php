<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Thông tin rạp</title>
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
                $cinema_pic = $row_cinema['Pic'];
                $cinema_map = $row_cinema['Map'];
                $cinema_adress = $row_cinema['Address'];
                $cinema_hotline = $row_cinema['Hotline'];

                if (!$result_cinema) {
                    die("Query failed: " . mysqli_error($connect));
                }
            }
        ?>

        <h1 class="mb-5"><a href="/BetaCinema_Clone/pages/index.php"><i class="bi bi-arrow-left-short"></i></a><?php echo htmlspecialchars($cinema_name); ?></h1> 
        <div class="text-center mb-5">
            <img src="<?php echo htmlspecialchars($cinema_pic);?>" class="img-fluid" alt="<?php echo htmlspecialchars($cinema_name); ?>">
        </div>
        <h5 class="mb-4">Nhằm đáp ứng nhu cầu vui giải trí của đông đảo bạn trẻ, Beta Cinemas đã có mặt tại <?php echo htmlspecialchars($cinema_adress); ?></h5>
        <h5 class="mb-4"><?php echo htmlspecialchars($cinema_name); ?> mang đến trải nghiệm xem phim chuẩn Hollywood với hệ thống máy chiếu, phòng chiếu hiện đại với 100% nhập khẩu từ nước ngoài, với 4 phòng chiếu tương đương 438 ghế ngồi. Hệ thống âm thanh Dolby 7.1 và hệ thống cách âm chuẩn quốc tế đảm bảo chất lượng âm thanh sống động nhất cho từng thước phim bom tấn.</h5>
        <h5 class="mb-4">Mức giá xem phim tại Beta Cinemas rất cạnh tranh: giá vé 2D chỉ từ 40.000 VNĐ và giá vé 3D chỉ từ 60.000 VNĐ. Không chỉ có vậy, rạp còn có nhiều chương trình khuyến mại, ưu đãi hàng tuần như đồng giá vé 40.000 vào các ngày Thứ 3 vui vẻ, Thứ 4 Beta's Day, đồng giá vé cho Học sinh sinh viên, người cao tuổi, trẻ em.....</h5>
        <h5 class="mb-4">Đến ngay Beta Cinemas để tận hưởng những giây phút vui vẻ cùng bạn bè trước màn hình chiếu phim với mức giá vô cùng ưu đãi nhé.</h5>
        <h5 class="mb-3">Thông tin liên hệ Rạp <?php echo htmlspecialchars($cinema_name); ?>:</h5>
        <h5 class="mb-1"><strong style="color: #337ab7">Địa chỉ: </strong><?php echo htmlspecialchars($cinema_adress); ?></h5>
        <h5 class="mb-4"><strong style="color: #337ab7">Điện thoại: </strong><?php echo htmlspecialchars($cinema_hotline); ?></h5>
        <h5 class="mb-4">Mua phiếu quà tặng, mua vé số lượng lớn, đặt phòng chiếu tổ chức hội nghị, trưng bày quảng cáo: <strong style="color: #337ab7">Liên hệ hotline - <?php echo htmlspecialchars($cinema_hotline); ?></strong> để được hưởng ưu đãi tốt nhất bạn nhé!</>
        
        <div class="map-container mt-5"> 
            <iframe src="<?php echo htmlspecialchars($cinema_map); ?>" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>        
        </div>

        <div class="text-center mt-5">
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

    iframe{
        border-radius: 20px;
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
