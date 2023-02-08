<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/showPassword.js" defer></script>
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
            <form class="extended-form" id="change-password-form" action="changePassword" method="post">
                <div class="form-align">
                    <p class="form-header">CHANGE PASSWORD</p>
                    <p>Current Password</p>
                    <input name="password" type="password">
                    <p>New Password</p>
                    <input name="new-password" type="password">
                    <p>Repeat New Password</p>
                    <input name="new-password-again" type="password">
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
                        <button type="submit">UPDATE</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>