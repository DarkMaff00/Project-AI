const form = document.querySelector("form");
const passwordInput = form.querySelector('input[name="password"]');
const newPasswordInput = form.querySelector('input[name="new-password"]');
const confirmedPasswordInput = form.querySelector('input[name="new-password-again"]');
const showPasswordCheckbox = form.querySelector('.show-password-box input[type="checkbox"]');

showPasswordCheckbox.addEventListener('change', function() {
    if (this.checked) {
        passwordInput.type = 'text';
        newPasswordInput.type = 'text';
        confirmedPasswordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
        newPasswordInput.type = 'password';
        confirmedPasswordInput.type = 'password';
    }
});