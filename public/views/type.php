<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/public/js/statistics.js" defer></script>
    <script type="text/javascript" src="/public/js/comments.js" defer></script>
    <title>Add your type</title>
</head>
<body>
    <div class="base-container">
        <?php
            require_once 'components/side-nav.php';
        ?>

        <main>
            <?php
                require_once 'components/header.php';
            ?>

            <section class="js-types">

                <div class="type-details-wrapper js-type-wrapper" id="<?= $type->getId(); ?>">
                    <div class="type-details">
                        <img class="type-details-image" src="/public/uploads/<?= $type->getImage(); ?>">
                        <div class="type-details-content">
                            <h1><?= $type->getTitle(); ?></h1>
                            <p><?= $type->getDescription(); ?></p>
                            <div class="type-social">
                                <div class="like">
                                    <i class="fas fa-heart js-like-button <?php if($type->getIsLiked()){ echo "type-social-icon"; } ?>"></i>
                                    <span class="js-like-content"><?= $type->getLikes(); ?></span>
                                </div>

                                <div class="dislike">
                                    <i class="fas fa-heart-broken js-dislike-button
                                    <?php if($type->getIsLiked() == false and !is_null($type->getIsLiked())) { echo "type-social-icon"; } ?>"></i>
                                    <span class="js-dislike-content"><?= $type->getDislikes(); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="type-details-create-comment-wrapper">
                            <textarea class="type-details-comments-textarea js-type-details-comments-textarea"></textarea>
                            <button class="js-type-details-add-comment-button">Comment</button>
                        </div>

                        <div class="js-comments-wrapper type-details-comments-wrapper">
                            <?php if($comments){
                            foreach($comments as $comment): ?>
                            <div class="type-details-comment-wrapper js-comment-wrapper" id="comment_<?=$comment->getId();?>">
                                <div class="type-details-comment-head">
                                    <div class="avatar">
                                        <a href="/user/<?=$comment->getUserDetails()->getUsername()?>">
                                            <img src="/public/uploads/<?= $comment->getUserDetails()->getImage(); ?>" alt="Avatar" class="js-avatar-image avatar-image img-fluid">
                                        </a>
                                    </div>
                                    <a href="/user/<?=$comment->getUserDetails()->getUsername()?>">
                                        <p><?= $comment->getUserDetails()->getUsername(); ?></p>
                                    </a>
                                </div>

                                <div class="type-details-comment-content-wrapper">
                                    <div class="type-details-comment-content">
                                        <span class="js-comment-message" contenteditable="false"><?=$comment->getMessage(); ?></span>
                                    </div>
                                    <p><?= $comment->getDate();?></p>
                                    <?php if($comment->getUserDetails()->getUsername() == $userDetails->getUsername()){?>
                                        <button class="js-comment-edit-button" onclick=editComment(<?=$comment->getId()?>)>Edit</button>
                                        <button class="js-comment-remove-button" onclick=removeComment(<?=$comment->getId()?>)>Remove</button>
                                    <?php }?>
                                </div>
                            </div>
                            <?php endforeach; } ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
?>

<template id="comment-wrapper-template">
    <div id="" class="type-details-comment-wrapper js-comment-wrapper">
        <div class="type-details-comment-head">
            <div class="avatar">
                <a class="js-comment-avatar-href" href="">
                    <img src="" alt="Avatar" class="js-comment-avatar-image avatar-image img-fluid">
                </a>
            </div>
            <a class="js-comment-username-href" href="">
                <p class="js-comment-username"></p>
            </a>
        </div>

        <div class="type-details-comment-content-wrapper">
            <div class="type-details-comment-content">
                <span class="js-comment-message" contenteditable="false"></span>
            </div>
            <p class="js-comment-date"></p>
            <button class="js-comment-edit-button"></button>
            <button class="js-comment-remove-button"></button>
        </div>
    </div>
</template>
