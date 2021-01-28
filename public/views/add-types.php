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

                    <section class="type-form-wrapper">
                        <h1 class="page-title">Add new type</h1>
                        <form class="add-type-form form-center" action="addType" method="POST" ENCTYPE="multipart/form-data">
                            <div class="message"><?php if(isset($messages)){foreach ($messages as $message) {echo $message;}} ?></div>
                            <select name="category">
                                <?php foreach ($categories as $category): ?>
                                <option value=<?=$category ?>><?= $category ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input class="form-input" name="title" type="text" placeholder="title">
                            <textarea class="form-input" name="description" rows="5" placeholder="description"></textarea>
                            <input class="form-input" type="file" name="file">
                            <button class="btn-submit-margin-top" type="submit">send</button>
                        </form>
                    </section>

                </section>
            </main>
        </div>
    </body>

<?php
    include 'templates/type-template.php';
?>
