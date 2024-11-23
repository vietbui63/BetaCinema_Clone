<?php
include './config.php';

if (!isset($_GET['id'])) {
    die("SeatID not provided.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM seats WHERE SeatID = $id";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Seat not found.");
}

$deleteQuery = "DELETE FROM seats WHERE SeatID = $id";
if (mysqli_query($connect, $deleteQuery)) {
    header("Location: /BetaCinema_Clone/admin/pages/index.php");
    exit();
} else {
    die("Error deleting seat: " . mysqli_error($connect));
}
?>
