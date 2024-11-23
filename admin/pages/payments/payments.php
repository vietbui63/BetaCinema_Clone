<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>PAYMENTS</title>

</head>
<body>
    <?php
        require 'config.php';

        $query = "SELECT * FROM payments";
        $result = mysqli_query($connect, $query);

        $stt = 1;
        
    ?>
    <div class="container mt-5">
        <a href="/BetaCinema_Clone/admin/pages/payments/add_payments.php" class="btn btn-success text-center mt-5">THÊM MỚI PAYMENTS</a>
        <table class="table table-info table-bordered border-info table-striped mt-3" id="font">
            <thead>
                <tr class="text-center">
                    <th scope="col">ID</th>
                    <th scope="col">NGÀY THANH TOÁN</th>
                    <th scope="col">PHƯƠNG THỨC</th>
                    <th scope="col">ID USERS</th>
                    <th scope="col">TÊN PHIM</th>
                    <th scope="col">RẠP CHIẾU</th>
                    <th scope="col">NGÀY CHIẾU</th>
                    <th scope="col">PHÒNG CHIẾU</th>
                    <th scope="col">GIỜ CHIẾU</th>
                    <th scope="col">GHẾ NGỒI</th>
                    <th scope="col">TỔNG GIÁ</th>
                    <th scope="col">Function</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='text-center'>";
                    echo "<td>".$stt++."</td>";
                    echo "<td>" . (!empty($row['PaymentDate']) ? date("d/m/Y", strtotime($row['PaymentDate'])) : "N/A") . "</td>";
                    echo "<td>" . htmlspecialchars($row['PaymentMethod']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['MovieTitle']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['CinemaName']) . "</td>";
                    echo "<td>" . (!empty($row['ShowDate']) ? date("d/m/Y", strtotime($row['ShowDate'])) : "N/A") . "</td>";
                    echo "<td>" . htmlspecialchars($row['HallName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['StartTime']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Seats']) . "</td>";
                    echo "<td>" . number_format($row['TotalPrice'], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>
                            <a href='/BetaCinema_Clone/admin/pages/payments/edit_payments.php?id=" . htmlspecialchars($row['PaymentID']) . "' class='btn btn-warning btn-sm'>SỬA</a>
                            <a href='/BetaCinema_Clone/admin/pages/payments/delete_payments.php?id=" . htmlspecialchars($row['PaymentID']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc chắn muốn xoá user này không?');\">XOÁ</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<style>
    thead th {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 200px;

    }

    tbody td {
        white-space: nowrap; 
        overflow: hidden;  
        text-overflow: ellipsis; 
        max-width: 150px; 
    }
    #font {
        font-size: 14px;
    }
</style>
</html>