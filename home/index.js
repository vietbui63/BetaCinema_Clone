window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        header.style.top = '-35px'; 
        navbar.style.top = '0'; 
    } else {
        header.style.top = '0'; 
        navbar.style.top = '35px'; 
    }
});

/* XỬ LÍ TABS */
document.getElementById('movieTabs').addEventListener('shown.bs.tab', function (event) {
    console.log(event.target.id);
});

/* REFRESH CAPTCHA */
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'captcha.php?' + Math.random();
}
