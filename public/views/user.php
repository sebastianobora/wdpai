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
                    <h1 class="page-title">User profile</h1>
                    <div class="user-details">
                        <div class="user-details-top">
                            <div class="user-details-info-wrapper">
                                <img class="user-details-avatar img-fluid" src="/public/uploads/<?= $fetchedUserDetails->getImage(); ?>">
                                <div class="user-details-content">
                                    <h1 class="type-details-title"><?= $fetchedUserDetails->getUsername(); ?></h1>
                                    <p class="user-details-data"><?= $fetchedUserDetails->getName(); ?></p>
                                    <p class="user-details-data"><?= $fetchedUserDetails->getSurname(); ?></p>
                                    <p class="user-details-data"><?= $fetchedUserDetails->getPhone(); ?></p>
                                </div>
                            </div>
                            <div class="user-details-management-buttons">
                                <?php if($fetchedUserDetails->getUsername() == $userDetails->getUsername() or $admin){?>
                                    <a class="type-details-management-button user-details-management-button" href="/editUser/<?=$fetchedUserDetails->getUsername();?>">
                                        <i class="fas fa-pencil-alt type-details-management-icon"></i>
                                    </a>
                                    <a class="type-details-management-button user-details-management-button" href="/deleteUser/<?=$fetchedUserDetails->getUsername();?>">
                                        <i class="far fa-trash-alt type-details-management-icon"></i>
                                    </a>
                                <?php }?>
                            </div>
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