const searchBar = document.querySelector('input[placeholder="What are you looking for?"]');
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
        loadTypes(types)
    });
}

function loadTypes(types) {
    types.forEach(type => {
        console.log(type);
        createType(type);
    });
}

function createType(type) {
    const template = document.querySelector("#type-template");

    const clone = template.content.cloneNode(true);

    const div = clone.querySelector("div");
    div.id = type.id;

    const image = clone.querySelector("img");
    image.src = `/public/uploads/${type.image}`;
    const title = clone.querySelector("h2");
    title.innerHTML = type.title;
    const description = clone.querySelector("p");
    description.innerHTML = type.description;
    const like = clone.querySelector(".like>span");
    like.innerText = type.like;
    const rate = clone.querySelector(".like>span");
    rate.innerText = type.rate;

    typeContainer.appendChild(clone);
}
