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
        }).then(function (comment) {
            console.log(comment);
            loadComment(comment);
        });
    }else{
        message.placeholder = "Message can't be empty!";
    }
    message.value = "";
});

function loadComment(comment){
    const template = document.querySelector("#comment-wrapper-template");
    const clone = template.content.cloneNode(true);

    const commentWrapper = clone.querySelector(".js-comment-wrapper");
    commentWrapper.id = "comment_"+comment.id;

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

    const commentRemoveButton = clone.querySelector(".js-comment-remove-button");
    commentRemoveButton.addEventListener("click", () => removeComment(comment.id));
    commentRemoveButton.innerHTML = "Remove";

    const commentEditButton = clone.querySelector(".js-comment-edit-button");
    commentEditButton.addEventListener("click", () => editComment(comment.id));
    commentEditButton.innerHTML = "Edit";

    commentsWrapper.appendChild(clone);
}

function removeComment(commentId){
    const data = {id: commentId};
    fetch("/removeComment", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(()=>{
        document.querySelector(`[id*="comment_${commentId}"]`).remove();
    })
}

function editComment(commentId){
    let commentWrapper = document.querySelector(`[id*="comment_${commentId}"]`);
    let commentMessage = commentWrapper.querySelector(".js-comment-message");
    let editButton = commentWrapper.querySelector(".js-comment-edit-button");
    if(commentMessage.contentEditable === 'false'){
        editButton.innerHTML = "Submit";
        commentMessage.contentEditable = true;
        commentMessage.focus();
    }else{
        editButton.innerHTML = "Edit";
        commentMessage.contentEditable = false;
        const data = {
            id: commentId,
            message: commentMessage.textContent
        };
        fetch("/editComment", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }
}