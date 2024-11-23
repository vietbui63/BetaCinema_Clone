<?php
    include './config.php';

    if (!isset($_GET['id'])) {
        die("PaymentID not provided.");
    }

    $id = intval($_GET['id']); 

    
    $query = "SELECT * FROM payments WHERE PaymentID = $id";
    $result = mysqli_query($connect, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("PaymentID not found.");
    }

    $deleteQuery = "DELETE FROM payments WHERE PaymentID = $id";
    if (mysqli_query($connect, $deleteQuery)) {
        echo "<script>
            alert('Payments đã được xóa thành công.');
            window.location.href = '/BetaCinema_Clone/admin/pages/index.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error: " . mysqli_real_escape_string($connect, mysqli_error($connect)) . "');
            window.history.back();
        </script>";
    }     
?>
