<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/style.css">
    <link rel="stylesheet" type="text/css" href="/public/CSS/types.css">

    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/button.js" defer></script>

    <title>TYPES</title>
</head>

<body>
    <div class="base-container">
        <nav>
            <img id="logo" src="/public/img/logo.svg">
            <ul>
                <li>
                    <i class="fas fa-chess"></i>
                    <a href="games" id="music" class="button">Games</a>
                </li>

                <li>
                    <i class="fas fa-music"></i>
                    <a href="music" id="music" class="button">Music</a>
                </li>

                <li>
                    <i class="far fa-play-circle"></i>
                    <a href="series" id="series" class="button">Series</a>
                </li>

                <li>
                    <i class="fas fa-film"></i>
                    <a href="movie" id="movie" class="button">Movie</a>
                </li>

                <li>
                    <i class="fas fa-book"></i>
                    <a href="book" id="book" class="button">Book</a>
                </li>

                <li>
                    <i class="fab fa-youtube-square"></i>
                    <a href="youtube" id="youtube" class="button">Youtube</a>
                </li>

                <li>
                    <i class="fab fa-instagram"></i>
                    <a href="instagram" id="instagram" class="button">Instagram</a>
                </li>
            </ul>
        </nav>

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

            <section class="types">
                <?php foreach($types as $type): ?>
                <div id="type-1">
                    <img src="/public/uploads/<?= $type->getImage() ?>">
                    <div>
                        <h2><?= $type->getTitle() ?></h2>
                        <p><?= $type->getDescription() ?></p>
                        <div class="social-section">

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