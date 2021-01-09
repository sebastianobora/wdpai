<DOCTYPE html>
    <head>
        <link rel="stylesheet" type="text/css" href="/public/CSS/style.css">
        <link rel="stylesheet" type="text/css" href="/public/CSS/authentication.css">

        <title>LOGIN PAGE</title>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-logo-container">
                <a href="login">
                    <img src="public/img/logo.svg">
                </a>
            </div>
            <div class="login-container">
                <form class="auth-form" action="login" method="post">
                    <div class="message">
                        <?php if(isset($messages)){
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        ?>
                    </div>
                    <div class="auth-inputs-wrapper">
                        <input class="form-input" name="email" type="text" placeholder="email@email.com">
                        <input class="form-input" name="password" type="password" placeholder="password">
                    </div>
                    <button type="submit">LOGIN</button>
                    <a href="register">Register</a>
                </form>
            </div>
        </div>
    </body>
</DOCTYPE>