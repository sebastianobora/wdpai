<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script src="https://kit.fontawesome.com/45d61cfa33.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/public/js/statistics.js" defer></script>
    <script type="text/javascript" src="/public/js/comments.js" defer></script>
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
                            <form class="user-edit-form" action="/editType" method="POST" ENCTYPE="multipart/form-data">
                                <input class="form-input" type="hidden" name="id" value="<?=$type->getId();?>">
                                <select name="category">
                                    <?php foreach ($categories as $category): ?>
                                        <option value=<?=$category ?>><?= $category ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input class="form-input" type="file" name="file">
                                <input class="form-input" name="title" type="text" value="<?=$type->getTitle();?>">
                                <textarea class="form-input" name="description" rows="5"><?=$type->getDescription();?></textarea>
                                <button type="submit">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
    include 'templates/comment-template.php';
?>
