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
                    <div class="user-delete-avatar-wrapper">
                        <img class="user-details-avatar user-delete-avatar img-fluid" src="/public/uploads/<?= $fetchedUserDetails->getImage(); ?>">
                    </div>

                    <form class="user-edit-form" action="/editUser" method="POST" ENCTYPE="multipart/form-data">
                        <input class="user-edit-username-input" name="username" type="text" value="<?= $fetchedUserDetails->getUsername(); ?>" readonly>
                        <input class="form-input" type="file" name="file">
                        <input class="form-input" name="name" type="text"
                            <?php if(!is_null($fetchedUserDetails->getName())){ ?> value="<?=$fetchedUserDetails->getName()?>" <? }else{ ?> placeholder="Name" <?;} ?>>
                        <input class="form-input" name="surname" type="text"
                            <?php if(!is_null($fetchedUserDetails->getSurname())){ ?> value="<?=$fetchedUserDetails->getSurname()?>" <?;}else{ ?> placeholder="Surname" <?;} ?>>
                        <input class="form-input" name="phone" type="tel" minlength="9" maxlength="14"
                            <?php if(!is_null($fetchedUserDetails->getPhone())){ ?> value="<?=$fetchedUserDetails->getPhone()?>" <?;}else{ ?> placeholder="Phone" <? } ?>>
                        <input class="form-input" name="password" type="password" placeholder="Current password">
                        <input class="form-input" name="newPassword" type="password" placeholder="New password">
                        <input class="form-input" name="confirmNewPassword" type="password" placeholder="Confirm new password">
                        <div class="message"><?php if(isset($messages)){foreach ($messages as $message) {echo $message;}} ?></div>
                        <button class="btn-submit-margin-top" type="submit">Save changes</button>
                    </form>
                </section>
            </section>
        </main>
    </div>
</body>

<?php
    include 'templates/type-template.php';
?>