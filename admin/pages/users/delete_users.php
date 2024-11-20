<?php
    include './config.php';

    if (!isset($_GET['id'])) {
        die("UserID not provided.");
    }

    $id = intval($_GET['id']); 

    $query = "SELECT * FROM users WHERE UserID = $id";
    $result = mysqli_query($connect, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("User not found.");
    }

    $deleteQuery = "DELETE FROM users WHERE UserID = $id";
    if (mysqli_query($connect, $deleteQuery)) {
        header("Location: /BetaCinema_Clone/admin/pages/index.php");
        exit();
    } else {
        die("Error deleting user: " . mysqli_error($connect));
    }
?>
