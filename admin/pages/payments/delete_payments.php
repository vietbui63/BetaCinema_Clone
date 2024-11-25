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
        header("Location: /BetaCinema_Clone/admin/pages/payments/payments.php");
        exit();
    } else {
        die("Error deleting seat: " . mysqli_error($connect));
    }     
?>
