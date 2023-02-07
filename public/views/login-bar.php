<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<header class="user-header">
    <div class="user-bar">
        <img id="bar-avatar" src="public/img/avatar.svg">
        <?php
        $user = new UserRepository();
        echo $user->getUser($_COOKIE['user'])->getLogin();
        ?>
        <img id="bar-arrow" src="public/img/menu-arrow.svg">
    </div>
</header>
