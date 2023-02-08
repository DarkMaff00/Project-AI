const logoImage = document.querySelector('img[alt="main-logo"]');
const userBar = document.querySelector('.user-bar');

logoImage.addEventListener('click', function () {
    window.location.href = 'http://localhost:8080';
});
logoImage.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});

userBar.addEventListener('click', function () {
    window.location.href = 'http://localhost:8080/settings';
});
userBar.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});