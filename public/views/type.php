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
                            <textarea class="type-details-comments-textarea js-type-details-comments-textarea"></textarea>
                            <button class="js-type-details-add-comment-button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
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
                                    <?php if($comment->getUserDetails()->getUsername() == $userDetails->getUsername() or $admin){?>
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
    include 'templates/comment-template.php';
?>
