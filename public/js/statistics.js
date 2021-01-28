const types = document.querySelectorAll(".js-type-wrapper");

function updateStatistics(likeContent, dislikeContent, likeButton, dislikeButton, value, id){
    const data = {value: value}
    fetch(`/like/${id}`, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function(response){
        return response.json();
    }).then(function(likeState){
        if(value){
            // like button set
            setButtonsStyle(likeButton, dislikeButton, likeContent, dislikeContent, likeState, value);
        }else{
            // dislike button set
            setButtonsStyle(dislikeButton, likeButton, dislikeContent, likeContent, likeState, value);
        }
    })
}

function setButtonsStyle(button1, button2, content1, content2, likeState, value){
    if(likeState === value){
        button1.classList.add('type-social-icon');
        content1.textContent = parseInt(content1.textContent) + 1;
        if(button2.classList.contains('type-social-icon')){
            button2.classList.remove('type-social-icon');
            content2.textContent = parseInt(content2.textContent) - 1;
        }
    }else{
    button1.classList.remove('type-social-icon');
    content1.textContent = parseInt(content1.textContent) - 1;
    }
}

types.forEach(type =>{
    const likeButton = type.querySelector(".js-like-button");
    const dislikeButton = type.querySelector(".js-dislike-button");

    const likeContent = type.querySelector(".js-like-content");
    const dislikeContent = type.querySelector(".js-dislike-content");

    const id = type.getAttribute("id");

    likeButton.addEventListener("click", () => updateStatistics(likeContent, dislikeContent, likeButton, dislikeButton, true, id));
    dislikeButton.addEventListener("click", () => updateStatistics(likeContent, dislikeContent, likeButton, dislikeButton, false, id));
});
