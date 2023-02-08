<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/friend.css">
    <title>ToMeet</title>
</head>
<body>
<div class="base-container">
    <?php include 'nav-bar.php'; ?>
    <main>
        <header class="search-header">
            <a class="add-button" href="http://localhost:8080/addFriend">
                + add friend
            </a>
            <?php
            if (isset($_COOKIE['user'])) { ?>
                <div class="user-bar">
                    <img id="bar-avatar" src="public/img/avatar.svg">
                    <?php
                    $user = new UserRepository();
                    echo $user->getUser($_COOKIE['user'])->getLogin();
                    ?>
                </div>
            <?php } ?>
        </header>
        <section class="friends">
            <p id="page-title">Friends</p>
            <div class="friends-align">
                <?php
                if (isset($friends)) {
                    foreach ($friends as $friend): ?>
                        <div id="friend1">
                            <div class="user-info">
                                <img src="public/img/avatar.svg">
                                <?php echo $friend->getLogin() ?>
                            </div>
                            <div class="events-number">
                                <p class="user-text"><?php echo $friend->getFirstname() . " " . $friend->getSurname() ?></p>
                                <p class="user-text"><?php echo $friend->getCity() . ", " . $friend->getCountry() ?></p>
                                <p class="user-text"><?php echo $friend->getEmail() ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                } ?>
            </div>
        </section>
    </main>
</div>
</body>