const searchBar = document.querySelector(".js-search-bar-input");
const typeContainer = document.querySelector(".js-types");

searchBar.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const data = {search: this.value};
        fetchTypes("/search", data);
    }});

function fetchTypes(input, data){
    fetch(input, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (types) {
        typeContainer.innerHTML = "";
        if(!typeContainer.classList.contains("types-wrapper")){
            typeContainer.classList.add("types-wrapper");
        }
        loadTypes(types)
    });
}

function loadTypes(types) {
    types.forEach(type => {
        createType(type);
    });
}

function createType(type) {
    const template = document.querySelector("#type-template");
    const clone = template.content.cloneNode(true);

    const likeButton = clone.querySelector(".js-like-button");
    const dislikeButton = clone.querySelector(".js-dislike-button");
    const likeContent = clone.querySelector(".js-like-content");
    const dislikeContent = clone.querySelector(".js-dislike-content");

    const typeWrapper = clone.querySelector(".js-type-wrapper");
    typeWrapper.id = type.id;

    const typeImageWrapper = clone.querySelector(".js-type-image-wrapper");
    typeImageWrapper.href = `/type/${type.id}`;

    const typeImage = clone.querySelector(".js-type-image");
    typeImage.src = `/public/uploads/${type.image}`;

    const typeHrefTitle = clone.querySelector(".js-type-href-title");
    typeHrefTitle.href = `/type/${type.id}`;

    const typeTitle = clone.querySelector(".js-type-title");
    typeTitle.innerHTML = type.title;

    const typeDescription = clone.querySelector(".js-type-description");
    typeDescription.innerHTML = type.description;

    const like = clone.querySelector(".js-like-content");
    like.textContent = type.likes;

    const dislike = clone.querySelector(".js-dislike-content");
    dislike.textContent = type.dislikes;

    if(type.isliked){
        likeButton.classList.add("type-social-icon");
    }
    if(type.isliked === false){
        dislikeButton.classList.add('type-social-icon');
    }

    likeButton.addEventListener("click", () => updateStatistics(likeContent, dislikeContent, likeButton, dislikeButton, true, typeWrapper.id));
    dislikeButton.addEventListener("click", () => updateStatistics(likeContent, dislikeContent, likeButton, dislikeButton, false, typeWrapper.id));

    typeContainer.appendChild(clone);
}
