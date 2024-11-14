<?php
    session_start();

    $captcha_code = '';
    
    for ($i = 0; $i < 5; $i++) {
        $captcha_code .= mt_rand(0, 9);
    }

    // Lưu mã CAPTCHA vào session
    $_SESSION['captcha'] = $captcha_code;

    // Tạo hình ảnh CAPTCHA
    header('Content-Type: image/png');
    $image = imagecreate(100, 30); 
    $background_color = imagecolorallocate($image, 255, 255, 255);  // Màu nền trắng
    $text_color = imagecolorallocate($image, 0, 0, 0);  // Màu chữ đen
    $line_color = imagecolorallocate($image, 64, 64, 64);  // Màu đường nét

    // Vẽ một số đường chéo để làm phức tạp CAPTCHA
    for ($i = 0; $i < 10; $i++) {
        imageline($image, mt_rand(0, 100), mt_rand(0, 30), mt_rand(0, 100), mt_rand(0, 30), $line_color);
    }

    // Thêm mã CAPTCHA vào hình ảnh
    imagestring($image, 10, 35, 5, $captcha_code, $text_color); // Điều chỉnh tọa độ văn bản cho phù hợp với chiều rộng và chiều cao mới

    // Hiển thị hình ảnh
    imagepng($image);
    imagedestroy($image);
?>
