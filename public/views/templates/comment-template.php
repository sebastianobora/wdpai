<template id="comment-wrapper-template">
    <div id="" class="type-details-comment-wrapper js-comment-wrapper">
        <div class="type-details-comment-head">
            <div class="type-details-comment-wrapper-info">
                <div class="avatar">
                    <a class="js-comment-avatar-href" href="">
                        <img src="" alt="Avatar" class="js-comment-avatar-image avatar-image img-fluid">
                    </a>
                </div>
                <div class="type-details-comment-col">
                    <a class="js-comment-username-href type-details-comment-user" href="">
                        <p class="js-comment-username type-details-comment-user-paragraph"></p>
                    </a>
                    <p class="type-details-comment-date js-comment-date">

                    </p>
                </div>
            </div>
            <div class="type-details-management-buttons">
                <span class="type-details-management-button js-comment-edit-button">
                    <i class="fas fa-pencil-alt type-details-management-icon"></i>
                </span>
                <span class="type-details-management-button js-comment-remove-button">
                    <i class="far fa-trash-alt type-details-management-icon"></i>
                </span>
            </div>
        </div>
        <div class="type-details-comment-content-wrapper">
            <div class="type-details-comment-content">
                <span class="js-comment-message" contenteditable="false"></span>
            </div>
        </div>
    </div>
</template>