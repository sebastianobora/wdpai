<DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
        <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
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

                    <section class="user-details-wrapper">
                        <div class="user-details">
                            <img class="user-details-avatar" src="/public/uploads/<?= $fetchedUserDetails->getImage(); ?>">
                            <div class="user-details-content">
                                <h1><?= $fetchedUserDetails->getUsername(); ?></h1>
                                <p><?= $fetchedUserDetails->getName(); ?></p>
                                <p><?= $fetchedUserDetails->getSurname(); ?></p>
                                <p><?= $fetchedUserDetails->getPhone(); ?></p>
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