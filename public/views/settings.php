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
        <section class="settings">
            <img id="big-logo" src="public/img/avatar.svg">
            <div class="login">
                <?php
                if(isset($user)){
                    echo $user->getLogin()."<br>";
                    echo $user->getFirstname()." ".$user->getSurname()."<br>";
                    echo $user->getCity().", ".$user->getCountry();
                }
                ?>
            </div>
            <a class="setting" href="http://localhost:8080/changePassword">
                <div>
                    Change password
                </div>
            </a>
            <a class="setting" href="http://localhost:8080/deleteAccount">
                <div>
                    Delete account
                </div>
            </a>
            <form action="logout" method="GET">
                <button>LOG OUT</button>
            </form>
        </section>
    </main>
    <?php include 'menu.php'; ?>
</div>
</body>