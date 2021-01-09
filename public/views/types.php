<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/style.css">
    <link rel="stylesheet" type="text/css" href="/public/CSS/types.css">
    <link rel="stylesheet" type="text/css" href="/public/CSS/nav.css">

    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/button.js" defer></script>

    <title>TYPES</title>
</head>

<body>
    <div class="base-container">
        <?php
            require_once 'side-nav.php';
        ?>

        <main>
            <header>
                <div class="search-bar">
                    <input placeholder="What are you looking for?">
                </div>

                <div class="add-your-type">
                    <i class="fas fa-plus"></i> add your type
                </div>

                <div class="avatar">
                    <img src="/public/uploads/<?= $avatar; ?>" alt="Avatar" class="avatar">
                </div>
            </header>

            <section class="js-types types-wrapper types">
                <?php foreach($types as $index => $type): ?>
                <div class="type-wrapper" id="type-<?= $index ?>">
                    <img class="type-image" src="/public/uploads/<?= $type->getImage() ?>">
                    <div class="type-content">
                        <h2><?= $type->getTitle() ?></h2>
                        <p><?= $type->getDescription() ?></p>
                        <div class="type-social">
                            <div class="like">
                                <i class="fas fa-heart"></i>
                                <span>600</span>
                            </div>

                            <div class="rate">
                                <i class="fas fa-star"></i>
                                <span>100</span>
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
    <div id="">
        <img src="">
        <div>
            <h2>title</h2>
            <p>description</p>
            <div class="social-section">

                <div class="like">
                    <i class="fas fa-heart"></i>
                    <span>0</span>
                </div>

                <div class="rate">
                    <i class="fas fa-star"></i>
                    <span>0</span>
                </div>

            </div>
        </div>
    </div>
</template>