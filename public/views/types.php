<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/public/js/statistics.js" defer></script>
    <title>TYPES</title>
</head>

<body>
    <div class="base-container">
        <?php
            include 'components/side-nav.php';
        ?>

        <main>
            <?php
                include 'components/header.php';
            ?>
                <section class="js-types types-wrapper">
                    <?php foreach($types as $type): ?>

                    <div class="type-wrapper js-type-wrapper" id="<?= $type->getId(); ?>">
                        <a class="type-image-wrapper" href="/type/<?=$type->getId() ?>">
                            <img class="type-image" src="/public/uploads/<?= $type->getImage(); ?>">
                        </a>
                        <div class="type-content">
                            <a class="type-href-title" href="/type/<?=$type->getId() ?>">
                                <h2><?= $type->getTitle(); ?></h2>
                            </a>
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


                <?php endforeach; ?>
                </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
?>

