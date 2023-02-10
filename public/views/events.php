<!DOCTYPE html>
<head>
    <link rel="icon" href="public/img/main-logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/event.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/eventManagment.js" defer></script>
    <title>ToMeet</title>
</head>
<body>
<div class="base-container">
    <?php include 'nav-bar.php'; ?>
    <main>
        <header class="search-header">
            <div class="search-bar">
                <input placeholder="search event">
            </div>
            <a class="add-button" href="http://localhost:8080/addEvent">
                + add event
            </a>
        </header>
        <section class="events">
            <p id="page-title">My events</p>
            <?php
            if (isset($events) and isset($members)) {
                foreach ($events as $event ): ?>
                    <div class="event-manage" id="<?php echo $event->getId() ?>">
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
                            <p>Number of participants: <?php echo $members[$event->getId()]."/".$event->getMaxNumber() ?></p>
                        </div>
                    </div>
                <?php endforeach;
            } ?>
        </section>
    </main>
    <?php include 'menu.php'; ?>
</div>
</body>

<template id="event-template">
    <div class="event-manage" id="event-1">
        <div class="organizer">
            <p>Organizer:</p>
            <img src="public/img/avatar.svg">
            <p id="organizer"></p>
        </div>
        <div class="name">
            <p id="event-title"></p>
            <p id="description"></p>
        </div>
        <div class="informations">
            <p id="place"></p>
            <p id="date"></p>
            <p id="time"></p>
            <p id="type"></p>
            <p id="maxNumber"></p>
        </div>
    </div>
</template>
