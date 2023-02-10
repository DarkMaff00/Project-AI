const logoImageBar = document.querySelector('img[alt="main-logo"]');
const userBar = document.querySelector('.user-bar');

logoImageBar.addEventListener('click', function () {
    window.location.href = 'http://localhost:8080';
});
logoImageBar.addEventListener('mouseover', function () {
    this.style.cursor = 'pointer';
});


if (typeof userBar !== 'undefined' && userBar !== null) {
    userBar.addEventListener('click', function () {
        window.location.href = 'http://localhost:8080/settings';
    });
    userBar.addEventListener('mouseover', function () {
        this.style.cursor = 'pointer';
    });
}