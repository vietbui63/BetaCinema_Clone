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
/* document.getElementById('movieTabs').addEventListener('shown.bs.tab', function (event) {
    console.log(event.target.id);
}); */

/* REFRESH CAPTCHA */
function refreshCaptcha() {
    document.getElementById('captcha-image').src = 'captcha.php?' + Math.random();
}



function submitForm() {
    var cinemaID = document.getElementById('cinemas').value;
    if (cinemaID) {
        document.getElementById('cinemaForm').submit();
    }
}

/* XỬ LÍ QUAY LẠI ĐẦU TRANG */
window.onscroll = function() { toggleScrollButton() };

function toggleScrollButton() {
    const backToTopBtn = document.getElementById("backToTopBtn");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        backToTopBtn.style.display = "block";
    } else {
        backToTopBtn.style.display = "none";
    }
}

// Scroll back to the top when button is clicked
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

