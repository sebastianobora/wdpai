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

                <section class="user-details-wrapper">
                    <div class="user-details">
                        <img class="user-details-avatar" src="/public/uploads/<?= $fetchedUserDetails->getImage(); ?>">
                        <div class="user-details-content">
                            <?php if($fetchedUserDetails->getUsername() == $userDetails->getUsername()){?>
                                <a href="/editUser/<?=$fetchedUserDetails->getUsername();?>" >Edit profile</a>
                                <a href="/editUser/<?=$fetchedUserDetails->getUsername();?>" >Delete profile</a>
                            <?php }?>
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

<?php
    include 'templates/type-template.php';
?>