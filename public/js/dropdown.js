let content = document.querySelector('.js-avatar-dropdown-content');
let avatar = document.querySelector('.js-avatar-image');

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