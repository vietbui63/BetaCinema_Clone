/* REFRESH CAPTCHA */
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'captcha.php?' + Math.random();
}