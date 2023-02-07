<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
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
        <section class="start-page">
            <p id="page-title">Welcome</p>
            <img id="big-logo-start" src="public/img/logo.svg">
            <div id="start-text">
                <p class="page-info">ToMeet is a site created to spend time with friends and meet new people.</p>
                <p class="page-info">To get started, just click the button below.</p>
            </div>
            <?php
            if (isset($_COOKIE['user'])) {
                ?>
                <a class="add-button" href="http://localhost:8080/addEvent">
                    <div>
                        Create Event
                    </div>
                </a>
            <?php } else { ?>
                <a class="add-button" href="http://localhost:8080/register">
                    <div>
                        Create Account
                    </div>
                </a>
                <a class="add-button" href="http://localhost:8080/login">
                    <div>
                        Log In
                    </div>
                </a>
            <?php } ?>
        </section>
    </main>
</div>
</body>