<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/public/js/statistics.js" defer></script>
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
                </div>

            </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
?>