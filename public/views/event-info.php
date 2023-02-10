<!DOCTYPE html>
<head>
    <link rel="icon" href="../public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="../public/css/event.css">
    <script type="text/javascript" src="../../public/js/eventManagment.js" defer></script>
    <script type="text/javascript" src="../../public/js/commentManagement.js" defer></script>
    <script type="text/javascript" src="../../public/js/nav.js" defer></script>
    <title>ToMeet</title>
</head>
<body>
<div class="base-container">
    <?php include 'nav-bar.php'; ?>
    <main>
        <?php
        if (isset($_COOKIE['user']) and isset($event) and isset($member)) {
            include 'login-bar.php';
        } ?>
        <section class="event-information">
            <div id="row-1">
                <p id="page-title-info"><?php echo $event->getName() ?></p>
                <div class="icons">
                    <img class="change-icons" src="public/img/delete.svg">
                </div>
            </div>
            <div id="row-2">
                <?php echo $event->getDescription() ?>
            </div>
            <div id="row-3">
                <div id="organizer-info">
                    <img src="public/img/avatar.svg">
                    <?php echo $event->getOrganizer() ?>
                </div>
                <div id="event-data">
                    <p>Place: <?php echo $event->getEventPlace() ?></p>
                    <p>Date: <?php echo $event->getEventDate() ?></p>
                    <p>Time: <?php echo $event->getEventTime() ?></p>
                    <?php if ($event->getEventType() != null) {
                        echo "<p>Type: " . $event->getEventType() . "</p>";
                    } ?>
                    <p>Number of participants: <?php echo $member . "/" . $event->getMaxNumber() ?></p>
                </div>
            </div>
            <div class="messages" style="color: red">
            </div>
            <div id="row-4">
                <div class="add-button" id="leave-event">
                    Leave event
                </div>
            </div>
        </section>
        <section class="forms">
            <form class="form-align">
                <input name="login-friend" type="text">
                <button id="add-friend" type="submit">Add friend</button>
            </form>
            <hr width="90%" color="black">
            <form  class="form-align">
                <input maxlength="200" type="text" name="content">
                <button id="add-comment" type="submit">Add comment</button>
            </form>
        </section>
        <section class="comments">
        </section>
    </main>
</div>
</body>

<template id="comment-template">
    <div class="comment" id="comment-1">
        <div class="comment-info">
            <p id="comment-author"></p>
            <p id="comment-date"></p>
        </div>
        <div class="comment-content">
            <p id="comment-text">content</p>
        </div>
    </div>
</template>