const types = document.querySelectorAll(".js-type-wrapper");

types.forEach(type =>{
    const likeButton = type.querySelector(".js-like-button");
    const dislikeButton = type.querySelector(".js-dislike-button");

    const likeContent = type.querySelector(".js-like-content");
    const dislikeContent = type.querySelector(".js-dislike-content");

    const id = type.getAttribute("id");

    likeButton.addEventListener("click", () => updateStatistics(likeContent, likeButton,"like", id));
    dislikeButton.addEventListener("click", () => updateStatistics(dislikeContent, dislikeButton,"dislike", id));
})


function updateStatistics(content, button, buttonType, id){
    fetch(`/${buttonType}/${id}`).then(function(){
        content.textContent = parseInt(content.textContent) + 1;
    })
}