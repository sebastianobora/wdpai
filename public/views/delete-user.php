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
                <section class="user-delete-wrapper">
                        <img class="user-details-avatar avatar-image" src="/public/uploads/<?= $fetchedUserDetails->getImage(); ?>">
                        <form class="user-delete-form" action="/deleteUser" method="POST" ENCTYPE="multipart/form-data">
                            <input class="user-edit-username-input" name="username" type="text" value="<?= $fetchedUserDetails->getUsername(); ?>" readonly>
                            <input class="form-input" name="password" type="password" placeholder="Enter password to confirm">
                            <?php if(isset($messages)){
                                foreach ($messages as $message) {
                                    echo $message;
                                }
                            }
                            ?>
                            <button type="submit">Remove account</button>
                        </form>
                </section>
            </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
?>