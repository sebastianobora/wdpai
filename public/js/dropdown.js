function dropdown() {
    let x = document.querySelector('.js-avatar-dropdown-content');
    if (x.style.display === "none" || x.style.display === "") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

window.onclick = function(event){
    let x = document.querySelector('.js-avatar-dropdown-content');
    console.log(event.target);
    if(!event.target.matches('.js-avatar-image')){
        x.style.display = "none";
    }
}
