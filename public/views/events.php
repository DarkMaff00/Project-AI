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
        <header class="search-header">
            <form class="search-bar">
                <input placeholder="search event">
            </form>
            <a class="add-button" href="http://localhost:8080/addEvent">
                + add event
            </a>
        </header>
        <section class="events">
            <p id="page-title">My events</p>
            <?php
            if (isset($events)) {
                foreach ($events as $event): ?>
                    <div id="event-<?php echo $event->getId() ?>">
                        <div class="organizer">
                            <p>Organizer:</p>
                            <img src="public/img/avatar.svg">
                            <p><?php echo $event->getOrganizer() ?></p>
                        </div>
                        <div class="name">
                            <p id="event-title"><?php echo $event->getName() ?></p>
                            <p><?php echo $event->getDescription() ?></p>
                        </div>
                        <div class="informations">
                            <p>Place: <?php echo $event->getEventPlace() ?></p>
                            <p>Date: <?php echo $event->getEventDate() ?></p>
                            <p>Time: <?php echo $event->getEventTime() ?></p>
                            <?php if($event->getEventType() != null) { echo "<p>Type: ".$event->getEventType()."</p>";} ?>
                            <p>Number of participants: <?php echo "/".$event->getMaxNumber() ?></p>
                        </div>
                    </div>
                <?php endforeach;
            } ?>
        </section>
    </main>
</div>
</body>