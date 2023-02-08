<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/event.css">
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
        <section class="event-information">
            <div id="row-1">
                <p id="page-title-info">Name</p>
                <div class="icons">
                    <img class="change-icons" src="public/img/edit.svg">
                    <img class="change-icons" src="public/img/delete.svg">
                    <form action="deleteEvent" method="get">
                        <button>Usun</button>
                    </form>
                </div>
            </div>
            <div id="row-2">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
                massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam
                felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede
                justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a,
                venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu
            </div>
            <div id="row-3">
                <div id="organizer-info">
                    <img src="public/img/avatar.svg">
                    Login
                </div>
                <div id="event-data">
                    <p>Place:</p>
                    <p>Date:</p>
                    <p>Time:</p>
                    <p>Type:</p>
                    <p>Number of participants:</p>
                </div>
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
            <div id="row-4">
                <form action="addToEvent" method="get">
                    <button>Add friend</button>
                </form>
                <div class="add-button">
                    Add friend
                </div>
                <div class="add-button">
                    Leave event
                </div>
                <form action="leaveEvent" method="get">
                    <button>Leave</button>
                </form>
            </div>
        </section>
        <section class="event-information">
            <form action="addComment" method="post">
                <input type="text" name="content">
                <button type="submit">Add</button>
            </form>
            <?php
            if (isset($comments)) {
                foreach ($comments as $comment):
                    echo $comment->getLoginUser();
                    echo substr($comment->getAddDate(),0,16);
                    echo $comment->getContent();
                endforeach;
            }
            ?>
            <form action="deleteComment" method="get">
                <button>Delete</button>
            </form>
        </section>
    </main>
</div>
</body>