<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/CSS/index.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>
    <link rel="shortcut icon" href="/favicon.ico">
    <title>register</title>
</head>

<body>
<div class="auth-container">

    <div class="auth-logo-container">
        <a href="login">
            <img class="img-fluid" src="public/img/logo.svg">
        </a>
    </div>

    <div class="login-container">
        <form class="auth-form" action="register" method="POST">
            <div class="message"><?php if(isset($messages)){foreach ($messages as $message) {echo $message;}} ?></div>
            <div class="auth-inputs-wrapper">
                <input class="form-input js-input-email" name="email" type="text" placeholder="email@email.com">
                <input class="form-input js-input-username" name="username" type="text" placeholder="username">
                <input class="form-input js-input-password" name="password" type="password" placeholder="password">
                <input class="form-input js-input-confirmedPassword" name="confirmedPassword" type="password" placeholder="confirm password">
            </div>
            <button type="submit">REGISTER</button>
        </form>
    </div>
</div>
</body>