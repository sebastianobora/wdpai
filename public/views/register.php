<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/CSS/authentication.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>
    <title>REGISTER</title>
</head>

<body>
<div class="auth-container">
    <div class="logo">
        <a href="/">
            <img src="public/img/logo.svg">
        </a>
    </div>
    <div class="login-container">
        <form class="auth-form" action="register" method="POST">
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <div class="auth-inputs-wrapper">
                <input class="form-input" name="email" type="text" placeholder="email@email.com">
                <input class="form-input" name="password" type="password" placeholder="password">
                <input class="form-input" name="confirmedPassword" type="password" placeholder="confirm password">
            </div>
            <button type="submit">REGISTER</button>
        </form>
    </div>
</div>
</body>