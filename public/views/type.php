<DOCTYPE html>
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

                    <section class="type-details-wrapper">
                        <div class="type-details">
                            <img class="type-details-image" src="/public/uploads/<?= $type->getImage(); ?>">
                            <div class="type-details-content">
                                <h1><?= $type->getTitle(); ?></h1>
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
                    </section>

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

</DOCTYPE>