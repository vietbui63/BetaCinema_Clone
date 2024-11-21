<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ADD MOVIES</title>
</head>
<body>
<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $release_date = $_POST['release_date'];
    $pic = $_POST['pic'];
    $trailer = $_POST['trailer'];
    $status = $_POST['status'];
    $special_show = $_POST['special_show'];

    $query = "INSERT INTO movies (Title, Type, Genre, Duration, ReleaseDate, Pic, Trailer, status, SpecialShow)
                    VALUES ('$title', '$type', '$genre', '$duration', '$release_date', '$pic', '$trailer', '$status', '$special_show')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header('Location: /BetaCinema_Clone/admin/pages/index.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<div class="container w-50">
    <h2 class="text-center text-success mb-4">THÊM MỚI MOVIE</h2>

    <form method="POST">
        <div class="row mt-5">
            <div class="col">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" required>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="number" class="form-control" id="duration" name="duration" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date</label>
                    <input type="date" class="form-control" id="release_date" name="release_date" required>
                </div>
                <div class="mb-3">
                    <label for="pic" class="form-label">Picture URL</label>
                    <input type="text" class="form-control" id="pic" name="pic" required>
                </div>
                <div class="mb-3">
                    <label for="trailer" class="form-label">Trailer URL</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" id="status" name="status" required>
                </div>
                <div class="mb-3">
                    <label for="special_show" class="form-label">Special Show</label>
                    <input type="number" class="form-control" id="special_show" name="special_show" required>
                </div>
            </div>
            <div class="row text-center">
                <button type="submit" class="btn btn-success mt-4">THÊM</button>
                <a href="/BetaCinema_Clone/admin/pages/index.php" class="btn btn-outline-success mt-3">QUAY LẠI</a>
            </div>
        </div>
    </form>
</div>
</body>
<style>
    body{
        background-color: #e5e5e5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container{
        border: 2px solid #198754;
        border-radius: 20px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-control{
        border: 1px solid #111;
    }

    label{
        font-weight: bold;
    }
</style>
</html>