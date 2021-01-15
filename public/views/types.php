<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
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

                    <div class="type-wrapper" id="<?= $type->getId(); ?>">
                        <a class="type-image-wrapper" href="/type/<?=$type->getId() ?>">
                            <img class="type-image" src="/public/uploads/<?= $type->getImage(); ?>">
                        </a>
                        <div class="type-content">
                            <a href="/type/<?=$type->getId() ?>">
                                <h2><?= $type->getTitle(); ?></h2>
                            </a>
                            <p><?= $type->getDescription(); ?></p>
                            <div class="type-social">
                                <div class="like">
                                    <i class="fas fa-heart"></i>
                                    <span><?= $type->getLike(); ?></span>
                                </div>

                                <div class="dislike">
                                    <i class="fas fa-heart-broken"></i>
                                    <span><?= $type->getDislike(); ?></span>
                                </div>

                            </div>
                        </div>
                    </div>


                <?php endforeach; ?>
                </section>
        </main>
    </div>
</body>

<template id="type-template">
    <div class="type-wrapper" id="">
        <img class="type-image" src="">
        <div class="type-content">
            <h2>title</h2>
            <p>description</p>
            <div class="type-social">

                <div>
                    <i class="fas fa-heart"></i>
                    <span class="js-like">0</span>
                </div>

                <div>
                    <i class="fas fa-heart-broken"></i>
                    <span class="js-dislike">0</span>
                </div>

            </div>
        </div>
    </div>
</template>