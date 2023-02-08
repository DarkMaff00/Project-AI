const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const loginInput = form.querySelector('input[name="login"]');
const confirmedPasswordInput = form.querySelector('input[name="extra-password"]');
const passwordInput = form.querySelector('input[name="password"]');
const showPasswordCheckbox = form.querySelector('.show-password-box input[type="checkbox"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function isLoginCorrect(login) {
    return login.length > 3;
}

function markValidation(element, condition) {
    if (!condition) {
        element.classList.add('no-valid');
        document.querySelector('.form-button-align button[type="submit"]').disabled = true;
    } else {
        element.classList.remove('no-valid');
        document.querySelector('.form-button-align button[type="submit"]').disabled = false;
    }
}

function validateEmail() {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        },
        1000
    );
}

function validatePassword() {
    setTimeout(function () {
            const condition = arePasswordsSame(
                passwordInput.value,
                confirmedPasswordInput.value
            );
            markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
}

function validateLogin() {
    setTimeout(function () {
            markValidation(loginInput, isLoginCorrect(loginInput.value));
        },
        1000
    );
}

showPasswordCheckbox.addEventListener('change', function() {
    if (this.checked) {
        passwordInput.type = 'text';
        confirmedPasswordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
        confirmedPasswordInput.type = 'password';
    }
});

emailInput.addEventListener('keyup', validateEmail);
confirmedPasswordInput.addEventListener('keyup', validatePassword);
loginInput.addEventListener('keyup', validateLogin);
