<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>ToMeet</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="public/img/logo.svg">
    </div>
    <div class="login-container" style="display: flex; justify-content: start; align-items: center">
        <form class="extended-form" action="login" method="POST">
            <div class="form-align">
                <p id="form-header">LOGIN</p>
                <div class="messages">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <p>Email</p>
                <input name="email" type="text">
                <p>Password</p>
                <input name="password" type="password">
                <div class="show-password-box">
                    <input type="checkbox" class="show">
                    <label for="show">Show password</label>
                </div>
                <div class="form-button-align">
                    <button type="submit">LOGIN</button>
                    <a href="http://localhost:8080/register">Sign Up</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>