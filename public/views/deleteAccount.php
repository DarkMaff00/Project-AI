<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/showPassword.js" defer></script>
    <meta name="viewport" content="width=device-width" />
    <title>ToMeet</title>
</head>
<body>
<div class="base-container">
    <?php include 'nav-bar.php'; ?>
    <main>
        <?php
        if (isset($_COOKIE['user'])) {
            include 'login-bar.php';
        } ?>
        <form class="extended-form" id="change-password-form" action="deleteAccount" method="post">
            <div class="form-align">
                <p class="form-header">DELETE ACCOUNT </p>
                <p>Password</p>
                <input name="password" type="password">
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
                    <button type="submit">DELETE</button>
                </div>
            </div>
        </form>
    </main>
    <?php include 'menu.php'; ?>
</div>
</body>