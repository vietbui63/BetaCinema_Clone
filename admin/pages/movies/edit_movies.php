<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BetaCinema_Clone/styles/admin.css">
    <title>EDIT MOVIE</title>
</head>
<body>
    <?php
        require 'config.php';

        if (!isset($_GET['movie_id'])) {
            die("MovieID not provided.");
        }

        $movie_id = intval($_GET['movie_id']);

        $query = "SELECT * FROM movies WHERE MoviesID = $movie_id";
        $result = mysqli_query($connect, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            die("Movie not found.");
        }

        $movie = mysqli_fetch_assoc($result);
        $mess = '';

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

            $updateQuery = "UPDATE movies 
                                    SET Title='$title', Type='$type', Genre='$genre', Duration='$duration', ReleaseDate='$release_date', Pic='$pic', Trailer='$trailer', status='$status', SpecialShow='$special_show' 
                                    WHERE MoviesID=$movie_id";

            if (mysqli_query($connect, $updateQuery)) {
                $mess = "Cập nhật thành công.";
            } else {
                $mess = "Error: " . mysqli_error($connect);
            }
        }
    ?>

    <div class="container w-50">
        <h2 class="text-center text-warning mb-4">CẬP NHẬT MOVIES</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tên phim</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= htmlspecialchars($movie['Title']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type"
                            value="<?= htmlspecialchars($movie['Type']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Thể loại</label>
                        <input type="text" class="form-control" id="genre" name="genre"
                            value="<?= htmlspecialchars($movie['Genre']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Thời lượng</label>
                        <input type="number" class="form-control" id="duration" name="duration"
                            value="<?= htmlspecialchars($movie['Duration']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="release_date" class="form-label">Ngày chiếu</label>
                        <input type="date" class="form-control" id="release_date" name="release_date"
                            value="<?= htmlspecialchars($movie['ReleaseDate']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pic" class="form-label">Picture URL</label>
                        <input type="text" class="form-control" id="pic" name="pic"
                            value="<?= htmlspecialchars($movie['Pic']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="trailer" class="form-label">Trailer URL</label>
                        <input type="text" class="form-control" id="trailer" name="trailer"
                            value="<?= htmlspecialchars($movie['Trailer']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Phim đang chiếu" <?php if ($movie['status'] == 'Phim đang chiếu') echo 'selected'; ?>>Phim đang chiếu</option>
                            <option value="Phim sắp chiếu" <?php if ($movie['status'] == 'Phim sắp chiếu') echo 'selected'; ?>>Phim sắp chiếu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="special_show" class="form-label">Special Show</label>
                        <select class="form-control" id="special_show" name="special_show">
                            <option value="0" <?php if ($movie['SpecialShow'] == '0') echo 'selected'; ?>>0</option>
                            <option value="1" <?php if ($movie['SpecialShow'] == '1') echo 'selected'; ?>>1</option>
                        </select>
                    </div>
                </div>
                <div class="col text-center mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-warning" style="margin-right:15px">QUAY LẠI</a>
                    <button type="submit" class="btn btn-warning">CẬP NHẬT</button>
                </div>
                <?php if ($mess): ?>
                    <div class='alert alert-success mt-4 p-1 text-center' id='mess' style='color:green; font-weight:bold'>
                        <?= $mess ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "/BetaCinema_Clone/admin/pages/movies/movies.php";
                        }, 1500);
                    </script>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .container {
        border: 2px solid #ffc107;
        border-radius: 20px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border: 1px solid #111;
    }

    label {
        font-weight: bold;
    }
</style>
</html>