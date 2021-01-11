const emailInput = document.querySelector('.js-input-email');
const passwordInput = document.querySelector('.js-input-password');
const confirmedPasswordInput = document.querySelector('.js-input-confirmedPassword');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmedPassword){
    return password === confirmedPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail(){
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        },
        1000
    );
}

function validatePassword(){
    //TODO: poziom skomplikowania hasła i czy jest odpowiednio zapisane
    setTimeout(function () {
            const condition = arePasswordsSame(passwordInput.value, confirmedPasswordInput.value);
            markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
}

emailInput.addEventListener('keyup', validateEmail);
confirmedPasswordInput.addEventListener('keyup', validatePassword);