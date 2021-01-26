const addCommentButton = document.querySelector(".js-type-details-add-comment-button");
const type = document.querySelector(".js-type-wrapper");
const message = document.querySelector(".js-type-details-comments-textarea");
const commentsWrapper = document.querySelector(".js-comments-wrapper");

addCommentButton.addEventListener('click', function (event) {
    if(message.value.replace(/\s/g, '').length){
        const data = {
            typeId: type.getAttribute("id"),
            message: message.value
        };
        fetch("/addComment", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (comments) {
            commentsWrapper.innerHTML = "";
            loadComment(comments);
        });
    }else{
        message.placeholder = "Message can't be empty!";
    }
    message.value = "";
});

function loadComment(comments){
    comments.forEach(comment => {
        console.log(comment);
        createComment(comment);
    });
}

function createComment(comment){
    const template = document.querySelector("#comment-wrapper-template");
    const clone = template.content.cloneNode(true);

    const commentWrapper = clone.querySelector(".js-comment-wrapper");
    commentWrapper.id = comment.id;

    const commentAvatar = clone.querySelector(".js-comment-avatar-href");
    commentAvatar.href = `/user/${comment.username}`;

    const commentAvatarImage = clone.querySelector(".js-comment-avatar-image");
    commentAvatarImage.src = `/public/uploads/${comment.avatar}`;

    const commentUsernameHref = clone.querySelector(".js-comment-username-href");
    commentUsernameHref.href = `/user/${comment.username}`;

    const commentUsername = clone.querySelector(".js-comment-username");
    commentUsername.innerHTML = comment.username;

    const commentMessage = clone.querySelector(".js-comment-message");
    commentMessage.innerHTML = comment.message;

    const commentDate = clone.querySelector(".js-comment-date");
    commentDate.innerHTML = comment.date;

    commentsWrapper.appendChild(clone);
}