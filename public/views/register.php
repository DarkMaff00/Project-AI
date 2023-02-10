<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/registerValidation.js" defer></script>
    <meta name="viewport" content="width=device-width" />
    <title>ToMeet</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="public/img/logo.svg">
        </div>
        <div class="login-container">
            <form class="extended-form" action="confirmRegistration" method="POST" style="margin-top: 2em">
                <div class="form-align">
                    <p id="form-header">SIGN UP</p>
                    <p>Login</p>
                    <input maxlength="30" name="login" type="text">
                    <p>Email</p>
                    <input maxlength="200" name="email" type="text">
                    <p>Name</p>
                    <input maxlength="50" name="firstname" type="text">
                    <p>Surname</p>
                    <input maxlength="50" name="surname" type="text">
                    <p>Country</p>
                    <input maxlength="50" name="country" type="text">
                    <p>City</p>
                    <input maxlength="50" name="city" type="text">
                    <p>Password</p>
                    <input maxlength="200" name="password" type="password">
                    <p>Repeat your password</p>
                    <input name="extra-password" type="password">
                    <div class="show-password-box">
                        <input type="checkbox" class="show">
                        <label for="show">Show password</label>
                    </div>
                    <div class="messages" style="color: red">
                        <?php
                        if (isset($messages)) {
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-button-align">
                        <button type="submit">SIGN UP</button>
                        <a href="http://localhost:8080/login">Log in</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>