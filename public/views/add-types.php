<DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="/public/CSS/style.css">
        <link rel="stylesheet" type="text/css" href="/public/CSS/types.css">
        <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="./public/js/button.js" defer></script>
        <script type="text/javascript" src="./public/js/search.js" defer></script>
        <title>TYPES</title>
    </head>
    <body>
        <div class="base-container">
            <nav>
                <img id="logo" src="/public/img/logo.svg">
                <ul>
                    <li>
                        <i class="fas fa-chess"></i>
                        <a id="games" class="button">Games</a>
                    </li>

                    <li>
                        <i class="fas fa-music"></i>
                        <a id="music" class="button">Music</a>
                    </li>

                    <li>
                        <i class="far fa-play-circle"></i>
                        <a id="series" class="button">Series</a>
                    </li>

                    <li>
                        <i class="fas fa-film"></i>
                        <a id="movie" class="button">Movie</a>
                    </li>

                    <li>
                        <i class="fas fa-book"></i>
                        <a id="book" class="button">Book</a>
                    </li>

                    <li>
                        <i class="fab fa-youtube-square"></i>
                        <a id="youtube" class="button">Youtube</a>
                    </li>

                    <li>
                        <i class="fab fa-instagram"></i>
                        <a id="instagram" class="button">Instagram</a>
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
                        <img src="/public/img/avatar.svg" alt="Avatar" class="avatar">
                    </div>

                </header>

                <section class="type-form">
                    <h1>UPLOAD</h1>
                    <form action="addType" method="POST" ENCTYPE="multipart/form-data">
                        <?php if(isset($messages)){
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        ?>
                        <input name="title" type="text" placeholder="title">
                        <textarea name="description" rows="5" placeholder="description"></textarea>
                        <input type="file" name="file">
                        <button type="submit">send</button>
                    </form>

                </section>

            </main>
        </div>
    </body>
</DOCTYPE>