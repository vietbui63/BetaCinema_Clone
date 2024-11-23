<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: /BetaCinema_Clone/pages/index.php");
    exit();
?>