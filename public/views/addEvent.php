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
            <form class="extended-form" id="change-password-form" style="margin-bottom: 2em;" action="addEvent" method="POST">
                <div class="form-align">
                    <p class="form-header">ADD EVENT</p>
                    <p>Name</p>
                    <input name="name" type="text">
                    <p>Description</p>
                    <textarea name="description" id="description"></textarea>
                    <div class="form-button-align" id="radios">
                        <div class="show-password-box">
                            <input name="mode" value="IRL" type="radio" class="show">
                            <label for="show">Real Life</label>
                        </div>
                        <div class="show-password-box">
                            <input name="mode" value="Online" type="radio" class="show">
                            <label for="show">Online</label>
                        </div>
                    </div>
                    <p>Place</p>
                    <input name="event-place" type="text">
                    <p>Date</p>
                    <input name="eventDate"  type="date">
                    <p>Time</p>
                    <input name="eventTime" type="time">
                    <p>Type</p>
                    <input name="event-type" type="text">
                    <p>Max number of participants</p>
                    <input name="maxNumber" type="number">
                    <div class="form-button-align" id="radios">
                        <div class="show-password-box">
                            <input name="access" value="private" type="radio" class="show">
                            <label for="show">Private</label>
                        </div>
                        <div class="show-password-box">
                            <input name="access" value="public" type="radio" class="show">
                            <label for="show">Public</label>
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
                    <div class="form-button-align">
                        <button type="submit">ADD EVENT</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>