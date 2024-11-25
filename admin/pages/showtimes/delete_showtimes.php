<?php
    include './config.php';

    if (!isset($_GET['id'])) {
        die("ShowtimeID not provided.");
    }

    $id = intval($_GET['id']); 
    

    $query = "SELECT * FROM show_times WHERE ShowtimeID = $id";
    $result = mysqli_query($connect, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("ShowtimeID not found.");
    }

    $deleteQuery = "DELETE FROM show_times WHERE ShowtimeID = $id";
    if (mysqli_query($connect, $deleteQuery)) {
        header("Location: /BetaCinema_Clone/admin/pages/showtimes/show_times.php");
        exit();
    } else {
        die("Error deleting seat: " . mysqli_error($connect));
    }     
?>
