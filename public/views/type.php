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
                    <img class="type-details-image img-fluid" src="/public/uploads/<?= $type->getImage(); ?>">
                    <div class="type-details">
                        <div class="type-details-content">
                            <h1 class="type-details-title"><?= $type->getTitle(); ?></h1>
                            <div class="type-details-management-wrapper">
                                <div class="type-details-management-infos">
                                    <a class="type-author-href" href="/types/<?=$type->getCategory()?>">
                                        Category: <?=$type->getCategory()?>
                                    </a>
                                    <a class="type-author-href" href="/user/<?=$author?>">
                                        Author: <?=$author?>
                                    </a>
                                    <span class="type-details-date">
                                        Date add: <?= $type->getCreatedAt(); ?>
                                    </span>
                                </div>
                                <div class="type-details-management-buttons">
                                    <?php if($author == $userDetails->getUsername() or $admin){?>
                                        <a class="type-details-management-button" href="/editType/<?=$type->getId();?>">
                                            <i class="fas fa-pencil-alt type-details-management-icon"></i>
                                        </a>
                                        <a class="type-details-management-button" href="/deleteType/<?=$type->getId();?>" >
                                            <i class="far fa-trash-alt type-details-management-icon"></i>
                                        </a>
                                    <?php }?>
                                </div>
                            </div>
                            <p class="type-details-description"><?= $type->getDescription(); ?></p>
                            <div class="type-social type-social-margin-bottom">
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
                            <label for="type-details-comment-textarea" class="type-details-comments-label">
                                Add your comment
                            </label>
                            <textarea name="type-details-comment-textarea" class="type-details-comments-textarea js-type-details-comments-textarea"></textarea>
                            <button class="js-type-details-add-comment-button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                        <div class="js-comments-wrapper type-details-comments-wrapper">
                            <?php if($comments){
                            foreach($comments as $comment): ?>
                            <div class="type-details-comment-wrapper js-comment-wrapper" id="comment_<?=$comment->getId();?>">
                                <div class="type-details-comment-head">
                                    <div class="type-details-comment-wrapper-info">
                                        <div class="avatar">
                                            <a href="/user/<?=$comment->getUserDetails()->getUsername()?>">
                                                <img src="/public/uploads/<?= $comment->getUserDetails()->getImage(); ?>" alt="Avatar" class="js-avatar-image avatar-image img-fluid">
                                            </a>
                                        </div>
                                        <div class="type-details-comment-col">
                                            <a class="type-details-comment-user" href="/user/<?=$comment->getUserDetails()->getUsername()?>">
                                                <p class="type-details-comment-user-paragraph">
                                                    <?= $comment->getUserDetails()->getUsername(); ?>
                                                </p>
                                            </a>
                                            <p class="type-details-comment-date">
                                                <?= $comment->getDate();?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if($comment->getUserDetails()->getUsername() == $userDetails->getUsername() or $admin){?>
                                        <div class="type-details-management-buttons">
                                            <span class="type-details-management-button js-comment-edit-button" onclick=editComment(<?=$comment->getId()?>)>
                                                <i class="fas fa-pencil-alt type-details-management-icon"></i>
                                            </span>
                                            <span class="type-details-management-button js-comment-remove-button" onclick=removeComment(<?=$comment->getId()?>)>
                                                <i class="far fa-trash-alt type-details-management-icon"></i>
                                        </span>
                                        </div>
                                    <?php }?>
                                </div>

                                <div class="type-details-comment-content-wrapper">
                                    <div class="type-details-comment-content">
                                        <span class="js-comment-message type-details-comment-message" contenteditable="false"><?=$comment->getMessage(); ?></span>
                                    </div>
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
    include 'templates/comment-template.php';
?>
