<?php
    include './config.php';

    if (!isset($_GET['id'])) {
        die("UserID not provided.");
    }

    $id = intval($_GET['id']); 

    $query = "DELETE FROM payments WHERE UserID = $id";
    mysqli_query($connect, $query);

    // Sau đó, xóa người dùng
    $deleteQuery = "DELETE FROM users WHERE UserID = $id";
    if (mysqli_query($connect, $deleteQuery)) {
        header("Location: /BetaCinema_Clone/admin/pages/users/users.php");
        exit();
    } else {
        die("Error deleting user: " . mysqli_error($connect));
    }

?>
