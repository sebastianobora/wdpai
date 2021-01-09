<DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">

        <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>

        <script type="text/javascript" src="./public/js/button.js" defer></script>
        <script type="text/javascript" src="./public/js/search.js" defer></script>

        <title>TYPES</title>
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

                <section class="js-types types-wrapper">

                    <section class="type-form">
                        <h1>UPLOAD</h1>
                        <form action="addType" method="POST" ENCTYPE="multipart/form-data">
                            <?php if(isset($messages)){
                                foreach ($messages as $message) {
                                    echo $message;
                                }
                            }
                            ?>
                            <input class="form-input" name="title" type="text" placeholder="title">
                            <textarea class="form-input" name="description" rows="5" placeholder="description"></textarea>
                            <input class="form-input" type="file" name="file">
                            <button type="submit">send</button>
                        </form>

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

</DOCTYPE>