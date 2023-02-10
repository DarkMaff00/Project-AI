<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
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
            <form class="extended-form" id="change-password-form" action="addFriend" method="post">
                <div class="form-align">
                    <p class="form-header">ADD FRIEND</p>
                    <p>Friend Login</p>
                    <input name="login" type="text" placeholder="login">
                    <div class="messages" style="color: red">
                        <?php
                        if (isset($messages)) {
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-button-align" id="friend-button">
                        <button type="submit">INVITE</button>
                    </div>
                </div>
            </form>
        </main>
        <?php include 'menu.php'; ?>
    </div>
</body>