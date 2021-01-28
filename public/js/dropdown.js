const content = document.querySelector('.js-avatar-dropdown-content');
const avatar = document.querySelector('.js-avatar-image');

function dropdown() {
    if (content.style.display === "none" || content.style.display === "") {
        content.style.display = "block";
        avatar.classList.add('avatar-image-shadow');
    } else {
        content.style.display = "none";
        avatar.classList.remove('avatar-image-shadow');
    }
}

window.onclick = function(event){
    if(!event.target.matches('.js-avatar-image')){
        content.style.display = "none";
        avatar.classList.remove('avatar-image-shadow');
    }
}

const navSideToggleSelector = '.js-menu-toggle';
const $navSide = document.querySelector('.js-nav-side');

document.addEventListener('click', function(event) {
    if (event.target.matches(navSideToggleSelector)) {
        event.preventDefault();

        $navSide.classList.toggle('nav-opened');
    }
}, false);

