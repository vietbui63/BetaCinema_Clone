<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Trailer</title>
</head>
<body>
    <?php
        require 'config.php';

        $movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : null;

        if ($movie_id) {
            $query = "SELECT * FROM movies WHERE MoviesID = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("i", $movie_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $trailer_url = $row['Trailer'];

                if (strpos($trailer_url, 'youtube.com/watch') !== false) {
                    $video_id = explode('v=', $trailer_url)[1];
                    $ampersandPosition = strpos($video_id, '&');
                    if ($ampersandPosition !== false) {
                        $video_id = substr($video_id, 0, $ampersandPosition);
                    }
                    $trailer_url = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=1';
                }

                echo '  <div class="container">';
                echo '      <h1 class="mb-4">' . 'TRAILER - ' . $row['Title'] . '</h1>';
                echo '      <div class="video-container">';
                echo '          <iframe src="' . htmlspecialchars($trailer_url) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                echo '      </div>';
                echo '      <a href="/BetaCinema_Clone/home/index.php" id="btn-back" class="btn btn-primary col-4 mt-4">
                                QUAY LẠI
                            </a>';
                echo '  </div>';

            } else {
                echo 'Movie not found.';
            }
            $stmt->close();
        } else {
            echo 'No movie selected.';
        }

        $connect->close();
    ?>
</body>
</html>

<style>
    body {
        background-image: url('/BetaCinema_Clone/assets/bg-play-trailer.png'); 
        background-position: center; 
        background-size: cover;
        background-repeat: no-repeat;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100vh;
    }

    .container {
        background: rgba(255, 255, 255, 0.5); 
        backdrop-filter: blur(20px); 
        text-align: center;
        width: 90%; 
        max-width: 800px; 
        margin: auto;
        padding: 20px;
        border-radius: 10px; 
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* Tỷ lệ khung hình 16:9 */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
        border-radius: 10px;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .btn{
        font-size: 20px;
        text-align: center;
        transition: 0.5s;
        background-size: 200% auto;
        color: white;
        font-weight: bold;
        border-radius: 10px;
        border: none;
    }

    .btn:hover {
        background-position: right center; 
    }

    #btn-back:hover{
        background-image: linear-gradient(to right, #0a64a7 0%, #258dcf 51%, #3db1f3 100%) !important;
    }
</style>
